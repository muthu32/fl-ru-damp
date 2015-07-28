<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/projects.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/projects_smail.php");

class projects_status 
{
    const SOLT = 'L29r9sF4ez63G6H';
    
    /**
     * ��������� ������ �������
     */
    const STATUS_NEW        =  0;//����������� ������ �� �� ���������� �������
    const STATUS_DECLINE    = -1;//����������� ��������� �� �������
    const STATUS_CANCEL     = -2;//�������� ������� ����������� ������ ������������ � ������ �����������
    const STATUS_ACCEPT     = 1;//������ � ������
    const STATUS_FRLCLOSE   = 2;//����������� ������ ������
    const STATUS_EMPCLOSE   = 3;//�������� ������ ������
    
    
    //��������� ������� ������ � ���������
    protected $STATUS_EMP_LIST = array(
        'cancel' => self::STATUS_CANCEL,
        'close' => self::STATUS_EMPCLOSE
    );
    
    //��������� ������� ������ � �����������
    protected $STATUS_FRL_LIST = array(
        'decline' => self::STATUS_DECLINE,
        'accept' => self::STATUS_ACCEPT,
        'close' => self::STATUS_FRLCLOSE
    );
    
    //� ����� ��������� ������ ������ ����� ����������
    protected $STATUS_NEXT = array(
        self::STATUS_NEW => array(
            self::STATUS_ACCEPT,
            self::STATUS_DECLINE,
            self::STATUS_CANCEL),
        self::STATUS_ACCEPT => array(
            self::STATUS_FRLCLOSE,
            self::STATUS_EMPCLOSE
        ),
        self::STATUS_DECLINE => array(
            self::STATUS_DECLINE,
            self::STATUS_CANCEL
        ),
        self::STATUS_CANCEL => array(
            self::STATUS_DECLINE,
            self::STATUS_CANCEL
        )
    );


    const TABLE_PROJECTS = 'projects';
    const TABLE_OFFERS   = 'projects_offers';

    protected $current_table = array(
        self::STATUS_ACCEPT => array(self::TABLE_PROJECTS,'project'),
        self::STATUS_FRLCLOSE => array(self::TABLE_PROJECTS,'project'),
        self::STATUS_EMPCLOSE => array(self::TABLE_PROJECTS,'project'),
        self::STATUS_DECLINE => array(self::TABLE_OFFERS,'offer'),
        self::STATUS_CANCEL => array(self::TABLE_OFFERS,'offer')
    );

    

   protected $project = array();
   protected $offer = array();
   protected $is_emp;



   protected $errors = array(1);
   protected $current_attributes = array();    
        
        
    
    
    
   /**
    * ��� ������?
    * 
    * @return type
    */ 
   public function is_valid()
   {
       return empty($this->errors);
   }

   
   /**
    * �������� ���������� ���������
    * 
    * @param string $key
    * @param mix $value
    * @return boolean
    */
   public function validation($key, $value) 
   {
        $error = FALSE;

        /*
        switch ($key) {
            
            case 'current_project_status':
                $error = !isset($this->STATUS_EMP_NEXT[$value]);
                break;
            case 'current_offer_status':
                $error = !isset($this->STATUS_FRL_NEXT[$value]);
                break;
        }
        */
        
        if ($error) {
            $this->errors[$key] = $error;
            return FALSE;
        }

        return TRUE;
    }
    
    
    
    
    /**
     * ������ ��� ������� ������
     * 
     * @param string $key
     * @param mix $value
     * @return mix
     */
    public function filter($key, $value)
    {
        return $value;
    }    

    
    

    /**
     * ������������� ��� ��������� ���������� ������
     * 
     * @param array $attributes
     * @return type
     */
    public function attributes($attributes = null) 
    {
        if (is_null($attributes)) 
        {
            return get_object_vars($this);
        }

       // $this->errors = array();

        foreach ($attributes as $key => $value) 
        {
            if (property_exists($this, $key)) 
            {
                //$value = $this->filter($key, $value);
                //$is_valid = $this->validation($key, $value);
                //if ($is_valid) 
                //{
                    //$this->current_attributes[] = $key;
                    $this->{$key} = $value;
                //}
            }
        }

       // return $this->is_valid();
    }

    
    //--------------------------------------------------------------------------
    
    
    /**
     * ���������� �� ������ ������� ������ � ��������
     * 
     * @param string $status
     * @return boolean
     */
    public function isOffer($status, $is_emp)
    {
        $list = ($is_emp)?$this->STATUS_EMP_LIST:$this->STATUS_FRL_LIST;
        if(!isset($list[$status])) return FALSE;
        return $this->current_table[$list[$status]][0] == self::TABLE_OFFERS;
    }


    //--------------------------------------------------------------------------
    
    /**
     * ������� ������� � ������ ��������� �������
     * 
     * @param string $new_status
     * @return boolean
     */
    public function changeStatus($new_status)
    {
        $list = ($this->is_emp)?$this->STATUS_EMP_LIST:$this->STATUS_FRL_LIST;
        $next = $this->STATUS_NEXT;
        //���������� �� ����� ������
        if(!isset($list[$new_status])) return FALSE;
        $status = $list[$new_status];
        //���� �� �������������� ��� ����?
        if(!isset($this->current_table[$status])) return FALSE;      
        $prop = $this->current_table[$status][1];
        $current_status = @$this->{$prop}['status'];
        //���� �� ������� ������ � �������� �� ������� � �����
        if(!isset($next[$current_status]) || 
           !in_array($list[$new_status], $next[$current_status])) return FALSE;

        $data = array('status' => $status);
        $time = time();
        
        //�������� ����� ������ �������
        switch($status)
        {
            case self::STATUS_DECLINE:
            case self::STATUS_CANCEL:
                //������ ���������� ���� ��� ����������
                if($this->project['status'] == self::STATUS_ACCEPT) return FALSE;

                //������� �� ������������
                $obj_project = new projects();
                $err = $obj_project->ClearExecutor($this->project['id'],$this->project['user_id']);
                if(!empty($err)) return FALSE;
                
                $obj_offer = new projects_offers();
                if ($this->project['kind'] == 9) {
                    //� ������������� ������� ��������� � �����
                    if ($status == self::STATUS_CANCEL) {
						$obj_offer->SetRefused($this->offer['id'], $this->project['id'], $this->project['exec_id']);
					} else {
						$this->db()->update(self::TABLE_OFFERS,array('status' => -1),'id = ?i',$this->offer['id']);
					}
                } else {
                    //��������� � ���������
                    $obj_offer->SetSelected($this->offer['id'], $this->project['id'], $this->project['exec_id'], true);
                }

                $this->project['exec_id'] = NULL;
                
                //���� ��� ������������ ������
                //�� ��������� ��� ����� ������
                if($this->project['kind'] == 9)
                {
                    $this->project['close_date'] = date('Y-m-d H:i:s', $time);
                    $this->project['closed'] = TRUE;
                    
                    $this->db()->update(self::TABLE_PROJECTS,array(
                        'close_date' => $this->project['close_date'],
                        'closed' => $this->project['closed']
                    ),'id = ?i',$this->project['id']);
                }
                
            break;
            
            case self::STATUS_ACCEPT:
                $now = date("Y-m-d H:i:s");
                $this->db()->update(self::TABLE_OFFERS,array('status' => 0),'id = ?i',$this->offer['id']);
                $this->db()->update(self::TABLE_PROJECTS,array('accept_date' => $now),'id = ?i',$this->project['id']);
                $this->offer['status'] = 0;
                
                //@todo: ��� ����� ������ � ����������???
                //����� ��������� ������ = 0 � ��������
                
            break;
        
            case self::STATUS_EMPCLOSE:
            case self::STATUS_FRLCLOSE:
                $data['close_date'] = date('Y-m-d H:i:s', $time);   
                $data['closed'] = TRUE;
                $this->project['close_date'] = $data['close_date'];
                $this->project['closed'] = $data['closed'];
                
            break;
        
            
        }

        $table = $this->current_table[$status][0];
        $id = @$this->{$prop}['id'];
        $is_ok = $this->db()->update($table,$data,'id = ?i',$id);

        if($is_ok)
        {
            $this->{$prop}['status'] = $status;
            
            //�������� ����������� � ����� �������
            $mes = new projects_smail();
            
            //�������� ����� �������� ����� �������
            switch($status)
            {
                case self::STATUS_ACCEPT:
                    $mes->onStartWorking($this->project, $this->offer);
                    break;
                
                case self::STATUS_CANCEL:
                    $mes->onRefuseFrl($this->project, $this->offer);
                    break;
             
                case self::STATUS_DECLINE:
                    $mes->onRefuseEmp($this->project, $this->offer);
                    break;
                
                case self::STATUS_EMPCLOSE:
                case self::STATUS_FRLCLOSE:
                    //��� ������ ��� �������� ���������� �� ���� ��� ������!
                    //$mes->onFinish($this->project, $this->is_emp);
                    break;
                 
            }
        }
        
        return $is_ok;
    }

    
    
    //--------------------------------------------------------------------------
    
    
    
    public function getProject()
    {
        return $this->project;
    }

    public function getOffer()
    {
        return $this->offer;
    }



    //--------------------------------------------------------------------------



    /**
     * ������� ���� ����
     * @return TServiceModel
     */
    public static function model() 
    {
        $class = get_called_class();
        return new $class;
    }

    
    //--------------------------------------------------------------------------
    
    
    /**
     * @return DB
     */
    public function db()
    {
        return $GLOBALS['DB'];
    }
}
