(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-e6be57be"],{"2ad3":function(t,e,n){"use strict";var a=n("7283");e["a"]=Object(a["a"])({render:function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{class:[t.b({fixed:t.fixed}),{"van-hairline--bottom":t.border}],style:t.style},[n("div",{class:t.b("left"),on:{click:function(e){t.$emit("click-left")}}},[t._t("left",[t.leftArrow?n("icon",{class:t.b("arrow"),attrs:{name:"arrow-left"}}):t._e(),t.leftText?n("span",{class:t.b("text"),domProps:{textContent:t._s(t.leftText)}}):t._e()])],2),n("div",{staticClass:"van-ellipsis",class:t.b("title")},[t._t("title",[t._v(t._s(t.title))])],2),n("div",{class:t.b("right"),on:{click:function(e){t.$emit("click-right")}}},[t._t("right",[t.rightText?n("span",{class:t.b("text"),domProps:{textContent:t._s(t.rightText)}}):t._e()])],2)])},name:"nav-bar",props:{title:String,fixed:Boolean,leftText:String,rightText:String,leftArrow:Boolean,border:{type:Boolean,default:!0},zIndex:{type:Number,default:1}},computed:{style:function(){return{zIndex:this.zIndex}}}})},"2e20":function(t,e,n){t.exports=n.p+"img/reload.54ce5878.svg"},"426b":function(t,e,n){"use strict";var a=n("784e"),i=n.n(a);i.a},"4abd":function(t,e,n){},7188:function(t,e,n){},7615:function(t,e,n){"use strict";n.r(e);var a,i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"content"},[n("nav-bar"),n("div",{staticClass:"router-view-content"},[n("keep-alive",[n("router-view")],1)],1),n("bottom-sidebar")],1)},r=[],o=(n("3a0f"),n("a3a3"),n("4d0b"),n("c989")),s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("van-nav-bar",{staticClass:"navbar",attrs:{title:t.title,"left-arrow":!t.leftArrow,fixed:!0},on:{"click-left":t.onClickLeft,"click-right":t.onClickRight}},[n("img",{attrs:{slot:"right",src:t.reload,alt:""},slot:"right"})])},c=[],l=n("c97d"),u=(n("d976"),n("c522")),f=(n("bdd5"),n("2ad3")),d=n("2e20"),m=n.n(d),h={components:(a={},Object(l["a"])(a,f["a"].name,f["a"]),Object(l["a"])(a,u["a"].name,u["a"]),a),mounted:function(){this.$route.params.title?this.title=this.$route.params.title:this.$route.meta&&this.$route.meta.routename&&(this.title=this.$route.meta.routename[0].name),this.leftArrow="User"===this.$route.name||"Products"===this.$route.name||"LaborCosts"===this.$route.name},watch:{route:function(t){t.params.title?this.title=t.params.title:t.meta&&t.meta.routename&&(this.title=t.meta.routename[0].name)},routeName:function(t){this.leftArrow=t}},computed:{route:function(){return this.$route},routeName:function(){if(this.$route.name)return"User"===this.$route.name||"Products"===this.$route.name||"LaborCosts"===this.$route.name}},data:function(){return{title:"",reload:m.a,leftArrow:!0}},methods:{onClickLeft:function(){this.$router.go(-1)},onClickRight:function(){window.location=window.location.pathname+"/"+new Date}}},b=h,p=(n("426b"),n("048f")),v=Object(p["a"])(b,s,c,!1,null,"77cea9a5",null);v.options.__file="navBar.vue";var w=v.exports,x={components:{"nav-bar":w,"bottom-sidebar":o["a"]}},_=x,$=(n("eccb"),Object(p["a"])(_,i,r,!1,null,"54c544a7",null));$.options.__file="layout.vue";e["default"]=$.exports},"784e":function(t,e,n){},bdd5:function(t,e,n){"use strict";n("6ec3"),n("4abd")},d976:function(t,e,n){"use strict";n("6ec3")},eccb:function(t,e,n){"use strict";var a=n("7188"),i=n.n(a);i.a}}]);
//# sourceMappingURL=chunk-e6be57be.06a55de2.js.map