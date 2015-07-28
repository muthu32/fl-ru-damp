var mn = {
    nn: function () {
        return function () {
            this.qn.rn(this, arguments);
        };
    },
    sn: function (tn, parent, body) {
        un(un(tn.prototype, parent.prototype), body);
    }
};

function un(hn, jn) {
    for (kn in jn) {
        hn[kn] = jn[kn];
    }
    return hn;
}
Function.prototype.ln = function (on) {
    var pn = this;
    return function () {
        return pn.rn(on, arguments);
    }
};
Function.prototype.dn = function (on) {
    var pn = this;
    return function (event) {
        pn.call(on, event || window.event);
    }
};
Number.prototype.en = function () {
    var fn = this.toString((11 + 5));
    if (this < (13 + 3)) return '0' + fn;
    return fn;
};
var gn = {
    an: function () {
        var returnValue;
        for (var i = 0; i < arguments.length; i++) {
            var bn = arguments[i];
            try {
                returnValue = bn();
                break;
            } catch (e) {}
        }
        return returnValue;
    }
};
var cn = mn.nn();
cn.prototype = {
    qn: function (vn, frequency) {
        this.vn = vn;
        this.frequency = frequency;
        this.wn = false;
        this.xn();
    },
    xn: function () {
        setInterval(this.yn.ln(this), this.frequency * (888 + 112));
    },
    yn: function () {
        if (!this.wn) {
            try {
                this.wn = true;
                this.vn();
            } finally {
                this.wn = false;
            }
        }
    }
};

function zn(id) {
    var x;
    if (!(x = document[id]) && document.all) x = document.all[id];
    if (!x && document.getElementById) x = document.getElementById(id);
    if (!x && !document.all && document.getElementsByName) {
        x = document.getElementsByName(id);
        if (x.length == 0) return null;
        if (x.length == 1) return x[0];
    }
    return x;
}
if (!Array.prototype.$n) {
    Array.prototype.$n = function () {
        var _n = this.length;
        for (var i = 0; i < arguments.length; i++) this[_n + i] = arguments[i];
        return this.length;
    };
}
function $() {
    var mq = new Array();
    for (var i = 0; i < arguments.length; i++) {
        var nq = arguments[i];
        if (typeof nq == 'string') nq = zn(nq);
        if (arguments.length == 1) return nq;
        mq.$n(nq);
    }
    return mq;
}
if (!Function.prototype.rn) {
    Function.prototype.rn = function (obj, params) {
        var qq = new Array();
        if (!obj) obj = window;
        if (!params) params = new Array();
        for (var i = 0; i < params.length; i++) qq[i] = 'params[' + i + ']';
        obj.$apply$ = this;
        var rq = eval('obj.$apply$(' + qq.join(', ') + ')');
        obj.$apply$ = null;
        return rq;
    };
}
var sq = {
    tq: function () {
        return gn.an(function () {
            return new ActiveXObject('Msxml2.XMLHTTP')
        }, function () {
            return new ActiveXObject('Microsoft.XMLHTTP')
        }, function () {
            return new XMLHttpRequest()
        }) || false;
    },
    uq: function (hq) {
        if (hq && hq.status >= 0310 && hq.status < 0454) {
            var iq = hq.responseXML;
            if (iq && iq.documentElement) return iq.documentElement;
        }
        return null;
    },
    jq: function (hq) {
        return hq.statusText || "connection error N" + hq.status;
    },
    kq: function () {}
};
sq.lq = function () {};
sq.lq.prototype = {
    oq: function (pq) {
        this.pq = un({
            dq: 'post',
            eq: true,
            fq: ''
        }, pq || {});
    },
    gq: function () {
        try {
            return this.aq.status || 0;
        } catch (e) {
            return 0
        }
    },
    bq: function () {
        var status = this.gq();
        return !status || (status >= 0310 && status < (282 + 18));
    },
    cq: function () {
        return !this.bq();
    }
};
sq.vq = mn.nn();
sq.vq.wq = ['Uninitialized', 'Loading', 'Loaded', 'Interactive', 'Complete'];
mn.sn(sq.vq, sq.lq, {
    qn: function (url, pq) {
        this.aq = sq.tq();
        this.oq(pq);
        this.xq = {};
        this.yq = false;
        this.zq(url);
    },
    zq: function (url) {
        var fq = this.pq.fq || '';
        if (fq.length > 0) fq += '&_=';
        try {
            if (this.pq.dq == 'get' && fq.length > 0) url += '?' + fq;
            this.aq.open(this.pq.dq.toUpperCase(), url, this.pq.eq);
            if (this.pq.eq) {
                this.aq.onreadystatechange = this.$q.ln(this);
                if (this.pq.timeout) {
                    this.xq = setTimeout(this._q.ln(this), this.pq.timeout);
                }
            }
            this.mr();
            var nr = this.pq.qr ? this.pq.qr : fq;
            this.aq.send(this.pq.dq == 'post' ? nr : null);
        } catch (e) {
            this.rr(e);
        }
    },
    mr: function () {
        var sr = ['X-Requested-With', 'XMLHttpRequest'];
        if (this.pq.dq == 'post') {
            sr.$n('Content-type', 'application/x-www-form-urlencoded');
            if (this.aq.overrideMimeType && (navigator.userAgent.match("/Gecko\/(\d{4} )/") || [0, 0x7d5])[1] < 03725) sr.$n('Connection', 'close');
        }
        if (this.pq.sr) sr.$n.rn(sr, this.pq.sr);
        for (var i = 0; i < sr.length; i += 2) this.aq.setRequestHeader(sr[i], sr[i + 1]);
    },
    $q: function () {
        var tr = this.aq.readyState;
        if (tr != 1) {
            this.ur(this.aq.readyState);
        }
    },
    _q: function () {
        if (this.yq) {
            return;
        }
        this.yq = true;
        (this.pq.hr || sq.kq)(this);
    },
    ur: function (tr) {
        if (typeof (sq) == "undefined") {
            return;
        }
        var event = sq.vq.wq[tr];
        if (event == 'Complete') {
            try {
                if (!this.yq) {
                    this.yq = true;
                    if (this.pq.timeout) {
                        clearTimeout(this.xq);
                    }(this.pq.onComplete || sq.kq)(this.aq);
                }
            } catch (e) {
                this.rr(e);
            }
            this.aq.onreadystatechange = sq.kq;
        }
    },
    rr: function (ir) {
        (this.pq.jr || sq.kq)(this, ir);
    }
});
var kr = {
    lr: function (obj, or, pr) {
        var dr = obj[or];
        if (typeof dr != 'function') {
            obj[or] = pr;
        } else {
            obj[or] = function () {
                dr();
                pr();
            }
        }
    }
};
var er = {
    fr: new Array,
    lr: function (gr) {
        er.fr.$n(gr);
    },
    ar: function () {
        kr.lr(window, 'onload', function () {
            er.rn();
        });
    },
    rn: function () {
        for (var h = 0; gr = er.fr[h]; h++) {
            for (br in gr) {
                fr = document.cr(br);
                if (!fr) continue;
                for (i = 0; element = fr[i]; i++) {
                    gr[br](element);
                }
            }
        }
    }
};
er.ar();

function vr(e) {
    return e.all ? e.all : e.getElementsByTagName('*');
}
document.cr = function (br) {
    if (!document.getElementsByTagName) {
        return new Array();
    }
    var wr = br.split(' ');
    var xr = new Array(document);
    for (var i = 0; i < wr.length; i++) {
        token = wr[i].replace(/^\s+/, '').replace(/\s+$/, '');;
        if (token.indexOf('#') > -1) {
            var yr = token.split('#');
            var zr = yr[0];
            var id = yr[1];
            var element = document.getElementById(id);
            if (element == null || zr && element.nodeName.toLowerCase() != zr) {
                return new Array();
            }
            xr = new Array(element);
            continue;
        }
        if (token.indexOf('.') > -1) {
            var yr = token.split('.');
            var zr = yr[0];
            var $r = yr[1];
            if (!zr) {
                zr = '*';
            }
            var _r = new Array;
            var ms = 0;
            for (var h = 0; h < xr.length; h++) {
                var elements;
                if (zr == '*') {
                    elements = vr(xr[h]);
                } else {
                    elements = xr[h].getElementsByTagName(zr);
                }
                if (elements == null) continue;
                for (var j = 0; j < elements.length; j++) {
                    _r[ms++] = elements[j];
                }
            }
            xr = new Array;
            var ns = 0;
            for (var k = 0; k < _r.length; k++) {
                if (_r[k].className && _r[k].className.match(new RegExp("\\b" + $r + "\\b"))) {
                    xr[ns++] = _r[k];
                }
            }
            continue;
        }
        if (!xr[0]) {
            return;
        }
        zr = token;
        var _r = new Array;
        var ms = 0;
        for (var h = 0; h < xr.length; h++) {
            var elements = xr[h].getElementsByTagName(zr);
            for (var j = 0; j < elements.length; j++) {
                _r[ms++] = elements[j];
            }
        }
        xr = _r;
    }
    return xr;
};
var qs = {
    rs: function (parent, name) {
        var ss = parent.getElementsByTagName(name);
        if (ss.length == 0) return "";
        ss = ss[0].childNodes;
        var ts = "";
        for (i = 0; i < ss.length; i++) ts += ss[i].nodeValue;
        return ts;
    },
    us: function (hs) {
        var is = hs.childNodes;
        var js = "";
        for (i = 0; i < is.length; i++) js += is[i].nodeValue;
        return js;
    },
    ks: function (parent, name) {
        for (k = 0; k < parent.attributes.length; k++) if (parent.attributes[k].nodeName == name) return parent.attributes[k].nodeValue;
        return null;
    }
};
var ls = {
    os: function (ps, ds) {
        var es = ds.rows[ps];
        if (es != null) return es;
        if (ds.rows['head'] != null) return null;
        for (k = 0; k < ds.rows.length; k++) {
            if (ds.rows[k].id == ps) return ds.rows[k];
        }
        return null;
    },
    fs: function (ps, es, ds) {
        var gs = es.cells[ps];
        if (gs != null) return gs;
        if (ds.rows['head'] != null) return null;
        for (k = 0; k < es.cells.length; k++) {
            if (es.cells[k].id == ps) return es.cells[k];
        }
        return null;
    },
    insertCell: function (es, ps, as, bs, cs, vs) {
        var ws = es.insertCell(-1);
        ws.id = ps;
        if (bs) ws.align = bs;
        ws.className = as;
        if (cs) ws.height = cs;
        ws.innerHTML = vs;
    }
};
var xs = mn.nn();
xs.prototype = {
    ys: navigator.userAgent.indexOf("MSIE") > -1,
    qn: function (zs, $s) {
        this.zs = zs;
        this.$s = $s;
    },
    _s: function (name, value) {
        var mt = new Date();
        mt.setTime(mt.getTime() + (8 + 2) * (314 + 51) * 0x18 * 0x3c * (40 + 20) * (690 + 310));
        document.cookie = name + "=" + encodeURIComponent(value) + "; expires=" + mt.toGMTString() + "; path=/";
    },
    nt: function (name) {
        var qt = name + "=";
        var rt = qt.length;
        var st = document.cookie.length;
        var i = 0;
        while (i < st) {
            var j = i + rt;
            if (document.cookie.substring(i, j) == qt) {
                var tt = document.cookie.indexOf(";", j);
                if (tt == -1) tt = document.cookie.length;
                return decodeURIComponent(document.cookie.substring(j, tt));
            }
            i = document.cookie.indexOf(" ", i) + 1;
            if (i == 0) break;
        }
        return null;
    },
    ut: function (ht) {
        this._s(this.$s, ht);
    },
    it: function () {
        return this.nt(this.$s) == 'true' || this.nt(this.$s) == null;
    },
    jt: function () {
        var kt;
        if (this.kt) {
            document.body.removeChild(this.kt);
        }
        if (this.ys) {
            kt = document.createElement("bgsound");
            kt.setAttribute('id', 'webim-sound-object');
            kt.setAttribute('name', 'webim-sound-object');
            kt.setAttribute('loop', '0');
        } else {
            kt = document.createElement("div");
            kt.setAttribute('id', 'webim-sound-object');
        }
        document.body.appendChild(kt);
        this.kt = kt;
    },
    lt: function () {
        var ot = "application/x-mplayer2";
        var userAgent = navigator.userAgent.toLowerCase();
        if (navigator.mimeTypes && userAgent.indexOf("windows") == -1) {
            var plugin = navigator.mimeTypes["audio/mpeg"].pt;
            if (plugin || userAgent.indexOf("opera") >= 0) {
                ot = "audio/mpeg";
            }
        }
        return ot;
    },
    ht: function () {
        if (!this.it()) {
            return;
        }
        this.jt();
        var obj = zn("webim-sound-object");
        if (this.ys) {
            obj.src = this.zs;
        } else {
            if ( !!document.createElement('audio').canPlayType ) {
                obj.innerHTML = '<audio autoplay><source src="' + this.zs + '"></audio>';
            } else {
                obj.innerHTML = '<embed type="' + this.lt() + '" src="' + this.zs + '" loop="0" autostart="1" width="0" height="0">';
            }
        }
    }
};

function dt(et, $s) {
    if (!document.xs) {
        document.xs = new xs(et, $s);
    }
}
function ft() {
    return document.xs;
}
function gt() {
    ft().ht();
}