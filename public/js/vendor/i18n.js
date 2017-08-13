!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):t.i18next=e()}(this,function(){"use strict";function t(t){return null==t?"":""+t}function e(t,e,n){t.forEach(function(t){e[t]&&(n[t]=e[t])})}function n(t,e,n){function o(t){return t&&t.indexOf("###")>-1?t.replace(/###/g,"."):t}function r(){return!t||"string"==typeof t}for(var i="string"!=typeof e?[].concat(e):e.split(".");i.length>1;){if(r())return{};var a=o(i.shift());!t[a]&&n&&(t[a]=new n),t=t[a]}return r()?{}:{obj:t,k:o(i.shift())}}function o(t,e,o){var r=n(t,e,Object),i=r.obj,a=r.k;i[a]=o}function r(t,e,o,r){var i=n(t,e,Object),a=i.obj,s=i.k;a[s]=a[s]||[],r&&(a[s]=a[s].concat(o)),r||a[s].push(o)}function i(t,e){var o=n(t,e),r=o.obj,i=o.k;if(r)return r[i]}function a(t,e,n){for(var o in e)o in t?"string"==typeof t[o]||t[o]instanceof String||"string"==typeof e[o]||e[o]instanceof String?n&&(t[o]=e[o]):a(t[o],e[o],n):t[o]=e[o];return t}function s(t){return t.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,"\\$&")}function l(t){return"string"==typeof t?t.replace(/[&<>"'\/]/g,function(t){return E[t]}):t}function u(t){return t.interpolation={unescapeSuffix:"HTML"},t.interpolation.prefix=t.interpolationPrefix||"__",t.interpolation.suffix=t.interpolationSuffix||"__",t.interpolation.escapeValue=t.escapeInterpolation||!1,t.interpolation.nestingPrefix=t.reusePrefix||"$t(",t.interpolation.nestingSuffix=t.reuseSuffix||")",t}function c(t){return t.resStore&&(t.resources=t.resStore),t.ns&&t.ns.defaultNs?(t.defaultNS=t.ns.defaultNs,t.ns=t.ns.namespaces):t.defaultNS=t.ns||"translation",t.fallbackToDefaultNS&&t.defaultNS&&(t.fallbackNS=t.defaultNS),t.saveMissing=t.sendMissing,t.saveMissingTo=t.sendMissingTo||"current",t.returnNull=!t.fallbackOnNull,t.returnEmptyString=!t.fallbackOnEmpty,t.returnObjects=t.returnObjectTrees,t.joinArrays="\n",t.returnedObjectHandler=t.objectTreeKeyHandler,t.parseMissingKeyHandler=t.parseMissingKey,t.appendNamespaceToMissingKey=!0,t.nsSeparator=t.nsseparator||":",t.keySeparator=t.keyseparator||".","sprintf"===t.shortcutFunction&&(t.overloadTranslationOptionHandler=function(t){for(var e=[],n=1;n<t.length;n++)e.push(t[n]);return{postProcess:"sprintf",sprintf:e}}),t.whitelist=t.lngWhitelist,t.preload=t.preload,"current"===t.load&&(t.load="currentOnly"),"unspecific"===t.load&&(t.load="languageOnly"),t.backend=t.backend||{},t.backend.loadPath=t.resGetPath||"locales/__lng__/__ns__.json",t.backend.addPath=t.resPostPath||"locales/add/__lng__/__ns__",t.backend.allowMultiLoading=t.dynamicLoad,t.cache=t.cache||{},t.cache.prefix="res_",t.cache.expirationTime=6048e5,t.cache.enabled=t.useLocalStorage,t=u(t),t.defaultVariables&&(t.interpolation.defaultVariables=t.defaultVariables),t}function p(t){return t=u(t),t.joinArrays="\n",t}function f(t){return(t.interpolationPrefix||t.interpolationSuffix||void 0!==t.escapeInterpolation)&&(t=u(t)),t.nsSeparator=t.nsseparator,t.keySeparator=t.keyseparator,t.returnObjects=t.returnObjectTrees,t}function g(t){t.lng=function(){return C.deprecate("i18next.lng() can be replaced by i18next.language for detected language or i18next.languages for languages ordered by translation lookup."),t.services.languageUtils.toResolveHierarchy(t.language)[0]},t.preload=function(e,n){C.deprecate("i18next.preload() can be replaced with i18next.loadLanguages()"),t.loadLanguages(e,n)},t.setLng=function(e,n,o){return C.deprecate("i18next.setLng() can be replaced with i18next.changeLanguage() or i18next.getFixedT() to get a translation function with fixed language or namespace."),"function"==typeof n&&(o=n,n={}),n||(n={}),n.fixLng===!0&&o?o(null,t.getFixedT(e)):t.changeLanguage(e,o)},t.addPostProcessor=function(e,n){C.deprecate("i18next.addPostProcessor() can be replaced by i18next.use({ type: 'postProcessor', name: 'name', process: fc })"),t.use({type:"postProcessor",name:e,process:n})}}function h(t){return t.charAt(0).toUpperCase()+t.slice(1)}function d(){var t={};return H.forEach(function(e){e.lngs.forEach(function(n){t[n]={numbers:e.nr,plurals:U[e.fc]}})}),t}function y(t,e){for(var n=t.indexOf(e);n!==-1;)t.splice(n,1),n=t.indexOf(e)}function v(){return{debug:!1,initImmediate:!0,ns:["translation"],defaultNS:["translation"],fallbackLng:["dev"],fallbackNS:!1,whitelist:!1,nonExplicitWhitelist:!1,load:"all",preload:!1,simplifyPluralSuffix:!0,keySeparator:".",nsSeparator:":",pluralSeparator:"_",contextSeparator:"_",saveMissing:!1,saveMissingTo:"fallback",missingKeyHandler:!1,postProcess:!1,returnNull:!0,returnEmptyString:!0,returnObjects:!1,joinArrays:!1,returnedObjectHandler:function(){},parseMissingKeyHandler:!1,appendNamespaceToMissingKey:!1,appendNamespaceToCIMode:!1,overloadTranslationOptionHandler:function(t){return{defaultValue:t[1]}},interpolation:{escapeValue:!0,format:function(t,e,n){return t},prefix:"{{",suffix:"}}",formatSeparator:",",unescapePrefix:"-",nestingPrefix:"$t(",nestingSuffix:")",defaultVariables:void 0}}}function b(t){return"string"==typeof t.ns&&(t.ns=[t.ns]),"string"==typeof t.fallbackLng&&(t.fallbackLng=[t.fallbackLng]),"string"==typeof t.fallbackNS&&(t.fallbackNS=[t.fallbackNS]),t.whitelist&&t.whitelist.indexOf("cimode")<0&&t.whitelist.push("cimode"),t}function m(){}var x="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},S=function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")},k=Object.assign||function(t){for(var e=1;e<arguments.length;e++){var n=arguments[e];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(t[o]=n[o])}return t},w=function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function, not "+typeof e);t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,enumerable:!1,writable:!0,configurable:!0}}),e&&(Object.setPrototypeOf?Object.setPrototypeOf(t,e):t.__proto__=e)},O=function(t,e){if(!t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!e||"object"!=typeof e&&"function"!=typeof e?t:e},L=function(){function t(t,e){var n=[],o=!0,r=!1,i=void 0;try{for(var a,s=t[Symbol.iterator]();!(o=(a=s.next()).done)&&(n.push(a.value),!e||n.length!==e);o=!0);}catch(t){r=!0,i=t}finally{try{!o&&s.return&&s.return()}finally{if(r)throw i}}return n}return function(e,n){if(Array.isArray(e))return e;if(Symbol.iterator in Object(e))return t(e,n);throw new TypeError("Invalid attempt to destructure non-iterable instance")}}(),j=function(t){if(Array.isArray(t)){for(var e=0,n=Array(t.length);e<t.length;e++)n[e]=t[e];return n}return Array.from(t)},N={type:"logger",log:function(t){this.output("log",t)},warn:function(t){this.output("warn",t)},error:function(t){this.output("error",t)},output:function(t,e){var n;console&&console[t]&&(n=console)[t].apply(n,j(e))}},P=function(){function t(e){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};S(this,t),this.init(e,n)}return t.prototype.init=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};this.prefix=e.prefix||"i18next:",this.logger=t||N,this.options=e,this.debug=e.debug},t.prototype.setDebug=function(t){this.debug=t},t.prototype.log=function(){for(var t=arguments.length,e=Array(t),n=0;n<t;n++)e[n]=arguments[n];return this.forward(e,"log","",!0)},t.prototype.warn=function(){for(var t=arguments.length,e=Array(t),n=0;n<t;n++)e[n]=arguments[n];return this.forward(e,"warn","",!0)},t.prototype.error=function(){for(var t=arguments.length,e=Array(t),n=0;n<t;n++)e[n]=arguments[n];return this.forward(e,"error","")},t.prototype.deprecate=function(){for(var t=arguments.length,e=Array(t),n=0;n<t;n++)e[n]=arguments[n];return this.forward(e,"warn","WARNING DEPRECATED: ",!0)},t.prototype.forward=function(t,e,n,o){return o&&!this.debug?null:("string"==typeof t[0]&&(t[0]=""+n+this.prefix+" "+t[0]),this.logger[e](t))},t.prototype.create=function(e){return new t(this.logger,k({prefix:this.prefix+":"+e+":"},this.options))},t}(),C=new P,R=function(){function t(){S(this,t),this.observers={}}return t.prototype.on=function(t,e){var n=this;t.split(" ").forEach(function(t){n.observers[t]=n.observers[t]||[],n.observers[t].push(e)})},t.prototype.off=function(t,e){var n=this;this.observers[t]&&this.observers[t].forEach(function(){if(e){var o=n.observers[t].indexOf(e);o>-1&&n.observers[t].splice(o,1)}else delete n.observers[t]})},t.prototype.emit=function(t){for(var e=arguments.length,n=Array(e>1?e-1:0),o=1;o<e;o++)n[o-1]=arguments[o];if(this.observers[t]){var r=[].concat(this.observers[t]);r.forEach(function(t){t.apply(void 0,n)})}if(this.observers["*"]){var i=[].concat(this.observers["*"]);i.forEach(function(e){var o;e.apply(e,(o=[t]).concat.apply(o,n))})}},t}(),E={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;","/":"&#x2F;"},A=function(t){function e(){var n=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},o=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{ns:["translation"],defaultNS:"translation"};S(this,e);var r=O(this,t.call(this));return r.data=n,r.options=o,r}return w(e,t),e.prototype.addNamespaces=function(t){this.options.ns.indexOf(t)<0&&this.options.ns.push(t)},e.prototype.removeNamespaces=function(t){var e=this.options.ns.indexOf(t);e>-1&&this.options.ns.splice(e,1)},e.prototype.getResource=function(t,e,n){var o=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{},r=o.keySeparator||this.options.keySeparator;void 0===r&&(r=".");var a=[t,e];return n&&"string"!=typeof n&&(a=a.concat(n)),n&&"string"==typeof n&&(a=a.concat(r?n.split(r):n)),t.indexOf(".")>-1&&(a=t.split(".")),i(this.data,a)},e.prototype.addResource=function(t,e,n,r){var i=arguments.length>4&&void 0!==arguments[4]?arguments[4]:{silent:!1},a=this.options.keySeparator;void 0===a&&(a=".");var s=[t,e];n&&(s=s.concat(a?n.split(a):n)),t.indexOf(".")>-1&&(s=t.split("."),r=e,e=s[1]),this.addNamespaces(e),o(this.data,s,r),i.silent||this.emit("added",t,e,n,r)},e.prototype.addResources=function(t,e,n){for(var o in n)"string"==typeof n[o]&&this.addResource(t,e,o,n[o],{silent:!0});this.emit("added",t,e,n)},e.prototype.addResourceBundle=function(t,e,n,r,s){var l=[t,e];t.indexOf(".")>-1&&(l=t.split("."),r=n,n=e,e=l[1]),this.addNamespaces(e);var u=i(this.data,l)||{};r?a(u,n,s):u=k({},u,n),o(this.data,l,u),this.emit("added",t,e,n)},e.prototype.removeResourceBundle=function(t,e){this.hasResourceBundle(t,e)&&delete this.data[t][e],this.removeNamespaces(e),this.emit("removed",t,e)},e.prototype.hasResourceBundle=function(t,e){return void 0!==this.getResource(t,e)},e.prototype.getResourceBundle=function(t,e){return e||(e=this.options.defaultNS),"v1"===this.options.compatibilityAPI?k({},this.getResource(t,e)):this.getResource(t,e)},e.prototype.toJSON=function(){return this.data},e}(R),T={processors:{},addPostProcessor:function(t){this.processors[t.name]=t},handle:function(t,e,n,o,r){var i=this;return t.forEach(function(t){i.processors[t]&&(e=i.processors[t].process(e,n,o,r))}),e}},M=function(t){function n(o){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};S(this,n);var i=O(this,t.call(this));return e(["resourceStore","languageUtils","pluralResolver","interpolator","backendConnector"],o,i),i.options=r,i.logger=C.create("translator"),i}return w(n,t),n.prototype.changeLanguage=function(t){t&&(this.language=t)},n.prototype.exists=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{interpolation:{}};return"v1"===this.options.compatibilityAPI&&(e=f(e)),void 0!==this.resolve(t,e)},n.prototype.extractFromKey=function(t,e){var n=e.nsSeparator||this.options.nsSeparator;void 0===n&&(n=":");var o=e.keySeparator||this.options.keySeparator||".",r=e.ns||this.options.defaultNS;if(n&&t.indexOf(n)>-1){var i=t.split(n);(n!==o||n===o&&this.options.ns.indexOf(i[0])>-1)&&(r=i.shift()),t=i.join(o)}return"string"==typeof r&&(r=[r]),{key:t,namespaces:r}},n.prototype.translate=function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};if("object"!==("undefined"==typeof e?"undefined":x(e))?e=this.options.overloadTranslationOptionHandler(arguments):"v1"===this.options.compatibilityAPI&&(e=f(e)),void 0===t||null===t||""===t)return"";"number"==typeof t&&(t=String(t)),"string"==typeof t&&(t=[t]);var n=e.keySeparator||this.options.keySeparator||".",o=this.extractFromKey(t[t.length-1],e),r=o.key,i=o.namespaces,a=i[i.length-1],s=e.lng||this.language,l=e.appendNamespaceToCIMode||this.options.appendNamespaceToCIMode;if(s&&"cimode"===s.toLowerCase()){if(l){var u=e.nsSeparator||this.options.nsSeparator;return a+u+r}return r}var c=this.resolve(t,e),p=Object.prototype.toString.apply(c),g=["[object Number]","[object Function]","[object RegExp]"],h=void 0!==e.joinArrays?e.joinArrays:this.options.joinArrays;if(c&&"string"!=typeof c&&g.indexOf(p)<0&&(!h||"[object Array]"!==p)){if(!e.returnObjects&&!this.options.returnObjects)return this.logger.warn("accessing an object - but returnObjects options is not enabled!"),this.options.returnedObjectHandler?this.options.returnedObjectHandler(r,c,e):"key '"+r+" ("+this.language+")' returned an object instead of string.";if(e.keySeparator||this.options.keySeparator){var d="[object Array]"===p?[]:{};for(var y in c)Object.prototype.hasOwnProperty.call(c,y)&&(d[y]=this.translate(""+r+n+y,k({},e,{joinArrays:!1,ns:i})));c=d}}else if(h&&"[object Array]"===p)c=c.join(h),c&&(c=this.extendTranslation(c,r,e));else{var v=!1,b=!1;if(this.isValidLookup(c)||void 0===e.defaultValue||(v=!0,c=e.defaultValue),this.isValidLookup(c)||(b=!0,c=r),b||v){this.logger.log("missingKey",s,a,r,c);var m=[],S=this.languageUtils.getFallbackCodes(this.options.fallbackLng,e.lng||this.language);if("fallback"===this.options.saveMissingTo&&S&&S[0])for(var w=0;w<S.length;w++)m.push(S[w]);else"all"===this.options.saveMissingTo?m=this.languageUtils.toResolveHierarchy(e.lng||this.language):m.push(e.lng||this.language);this.options.saveMissing&&(this.options.missingKeyHandler?this.options.missingKeyHandler(m,a,r,c):this.backendConnector&&this.backendConnector.saveMissing&&this.backendConnector.saveMissing(m,a,r,c)),this.emit("missingKey",m,a,r,c)}c=this.extendTranslation(c,r,e),b&&c===r&&this.options.appendNamespaceToMissingKey&&(c=a+":"+r),b&&this.options.parseMissingKeyHandler&&(c=this.options.parseMissingKeyHandler(c))}return c},n.prototype.extendTranslation=function(t,e,n){var o=this;n.interpolation&&this.interpolator.init(k({},n,{interpolation:k({},this.options.interpolation,n.interpolation)}));var r=n.replace&&"string"!=typeof n.replace?n.replace:n;this.options.interpolation.defaultVariables&&(r=k({},this.options.interpolation.defaultVariables,r)),t=this.interpolator.interpolate(t,r,n.lng||this.language),n.nest!==!1&&(t=this.interpolator.nest(t,function(){return o.translate.apply(o,arguments)},n)),n.interpolation&&this.interpolator.reset();var i=n.postProcess||this.options.postProcess,a="string"==typeof i?[i]:i;return void 0!==t&&a&&a.length&&n.applyPostProcessor!==!1&&(t=T.handle(a,t,e,n,this)),t},n.prototype.resolve=function(t){var e=this,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},o=void 0;return"string"==typeof t&&(t=[t]),t.forEach(function(t){if(!e.isValidLookup(o)){var r=e.extractFromKey(t,n),i=r.key,a=r.namespaces;e.options.fallbackNS&&(a=a.concat(e.options.fallbackNS));var s=void 0!==n.count&&"string"!=typeof n.count,l=void 0!==n.context&&"string"==typeof n.context&&""!==n.context,u=n.lngs?n.lngs:e.languageUtils.toResolveHierarchy(n.lng||e.language);a.forEach(function(t){e.isValidLookup(o)||u.forEach(function(r){if(!e.isValidLookup(o)){var a=i,u=[a],c=void 0;s&&(c=e.pluralResolver.getSuffix(r,n.count)),s&&l&&u.push(a+c),l&&u.push(a+=""+e.options.contextSeparator+n.context),s&&u.push(a+=c);for(var p=void 0;p=u.pop();)e.isValidLookup(o)||(o=e.getResource(r,t,p,n))}})})}}),o},n.prototype.isValidLookup=function(t){return!(void 0===t||!this.options.returnNull&&null===t||!this.options.returnEmptyString&&""===t)},n.prototype.getResource=function(t,e,n){var o=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{};return this.resourceStore.getResource(t,e,n,o)},n}(R),_=function(){function t(e){S(this,t),this.options=e,this.whitelist=this.options.whitelist||!1,this.logger=C.create("languageUtils")}return t.prototype.getScriptPartFromCode=function(t){if(!t||t.indexOf("-")<0)return null;var e=t.split("-");return 2===e.length?null:(e.pop(),this.formatLanguageCode(e.join("-")))},t.prototype.getLanguagePartFromCode=function(t){if(!t||t.indexOf("-")<0)return t;var e=t.split("-");return this.formatLanguageCode(e[0])},t.prototype.formatLanguageCode=function(t){if("string"==typeof t&&t.indexOf("-")>-1){var e=["hans","hant","latn","cyrl","cans","mong","arab"],n=t.split("-");return this.options.lowerCaseLng?n=n.map(function(t){return t.toLowerCase()}):2===n.length?(n[0]=n[0].toLowerCase(),n[1]=n[1].toUpperCase(),e.indexOf(n[1].toLowerCase())>-1&&(n[1]=h(n[1].toLowerCase()))):3===n.length&&(n[0]=n[0].toLowerCase(),2===n[1].length&&(n[1]=n[1].toUpperCase()),"sgn"!==n[0]&&2===n[2].length&&(n[2]=n[2].toUpperCase()),e.indexOf(n[1].toLowerCase())>-1&&(n[1]=h(n[1].toLowerCase())),e.indexOf(n[2].toLowerCase())>-1&&(n[2]=h(n[2].toLowerCase()))),n.join("-")}return this.options.cleanCode||this.options.lowerCaseLng?t.toLowerCase():t},t.prototype.isWhitelisted=function(t){return("languageOnly"===this.options.load||this.options.nonExplicitWhitelist)&&(t=this.getLanguagePartFromCode(t)),!this.whitelist||!this.whitelist.length||this.whitelist.indexOf(t)>-1},t.prototype.getFallbackCodes=function(t,e){if(!t)return[];if("string"==typeof t&&(t=[t]),"[object Array]"===Object.prototype.toString.apply(t))return t;if(!e)return t.default||[];var n=t[e];return n||(n=t[this.getScriptPartFromCode(e)]),n||(n=t[this.formatLanguageCode(e)]),n||(n=t.default),n||[]},t.prototype.toResolveHierarchy=function(t,e){var n=this,o=this.getFallbackCodes(e||this.options.fallbackLng||[],t),r=[],i=function(t){t&&(n.isWhitelisted(t)?r.push(t):n.logger.warn("rejecting non-whitelisted language code: "+t))};return"string"==typeof t&&t.indexOf("-")>-1?("languageOnly"!==this.options.load&&i(this.formatLanguageCode(t)),"languageOnly"!==this.options.load&&"currentOnly"!==this.options.load&&i(this.getScriptPartFromCode(t)),"currentOnly"!==this.options.load&&i(this.getLanguagePartFromCode(t))):"string"==typeof t&&i(this.formatLanguageCode(t)),o.forEach(function(t){r.indexOf(t)<0&&i(n.formatLanguageCode(t))}),r},t}(),H=[{lngs:["ach","ak","am","arn","br","fil","gun","ln","mfe","mg","mi","oc","tg","ti","tr","uz","wa"],nr:[1,2],fc:1},{lngs:["af","an","ast","az","bg","bn","ca","da","de","dev","el","en","eo","es","es_ar","et","eu","fi","fo","fur","fy","gl","gu","ha","he","hi","hu","hy","ia","it","kn","ku","lb","mai","ml","mn","mr","nah","nap","nb","ne","nl","nn","no","nso","pa","pap","pms","ps","pt","pt_br","rm","sco","se","si","so","son","sq","sv","sw","ta","te","tk","ur","yo"],nr:[1,2],fc:2},{lngs:["ay","bo","cgg","fa","id","ja","jbo","ka","kk","km","ko","ky","lo","ms","sah","su","th","tt","ug","vi","wo","zh"],nr:[1],fc:3},{lngs:["be","bs","dz","hr","ru","sr","uk"],nr:[1,2,5],fc:4},{lngs:["ar"],nr:[0,1,2,3,11,100],fc:5},{lngs:["cs","sk"],nr:[1,2,5],fc:6},{lngs:["csb","pl"],nr:[1,2,5],fc:7},{lngs:["cy"],nr:[1,2,3,8],fc:8},{lngs:["fr"],nr:[1,2],fc:9},{lngs:["ga"],nr:[1,2,3,7,11],fc:10},{lngs:["gd"],nr:[1,2,3,20],fc:11},{lngs:["is"],nr:[1,2],fc:12},{lngs:["jv"],nr:[0,1],fc:13},{lngs:["kw"],nr:[1,2,3,4],fc:14},{lngs:["lt"],nr:[1,2,10],fc:15},{lngs:["lv"],nr:[1,2,0],fc:16},{lngs:["mk"],nr:[1,2],fc:17},{lngs:["mnk"],nr:[0,1,2],fc:18},{lngs:["mt"],nr:[1,2,11,20],fc:19},{lngs:["or"],nr:[2,1],fc:2},{lngs:["ro"],nr:[1,2,20],fc:20},{lngs:["sl"],nr:[5,1,2,3],fc:21}],U={1:function(t){return Number(t>1)},2:function(t){return Number(1!=t)},3:function(t){return 0},4:function(t){return Number(t%10==1&&t%100!=11?0:t%10>=2&&t%10<=4&&(t%100<10||t%100>=20)?1:2)},5:function(t){return Number(0===t?0:1==t?1:2==t?2:t%100>=3&&t%100<=10?3:t%100>=11?4:5)},6:function(t){return Number(1==t?0:t>=2&&t<=4?1:2)},7:function(t){return Number(1==t?0:t%10>=2&&t%10<=4&&(t%100<10||t%100>=20)?1:2)},8:function(t){return Number(1==t?0:2==t?1:8!=t&&11!=t?2:3)},9:function(t){return Number(t>=2)},10:function(t){return Number(1==t?0:2==t?1:t<7?2:t<11?3:4)},11:function(t){return Number(1==t||11==t?0:2==t||12==t?1:t>2&&t<20?2:3)},12:function(t){return Number(t%10!=1||t%100==11)},13:function(t){return Number(0!==t)},14:function(t){return Number(1==t?0:2==t?1:3==t?2:3)},15:function(t){return Number(t%10==1&&t%100!=11?0:t%10>=2&&(t%100<10||t%100>=20)?1:2)},16:function(t){return Number(t%10==1&&t%100!=11?0:0!==t?1:2)},17:function(t){return Number(1==t||t%10==1?0:1)},18:function(t){return Number(0==t?0:1==t?1:2)},19:function(t){return Number(1==t?0:0===t||t%100>1&&t%100<11?1:t%100>10&&t%100<20?2:3)},20:function(t){return Number(1==t?0:0===t||t%100>0&&t%100<20?1:2)},21:function(t){return Number(t%100==1?1:t%100==2?2:t%100==3||t%100==4?3:0)}},V=function(){function t(e){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};S(this,t),this.languageUtils=e,this.options=n,this.logger=C.create("pluralResolver"),this.rules=d()}return t.prototype.addRule=function(t,e){this.rules[t]=e},t.prototype.getRule=function(t){return this.rules[this.languageUtils.getLanguagePartFromCode(t)]},t.prototype.needsPlural=function(t){var e=this.getRule(t);return e&&e.numbers.length>1},t.prototype.getSuffix=function(t,e){var n=this,o=this.getRule(t);if(o){if(1===o.numbers.length)return"";var r=o.noAbs?o.plurals(e):o.plurals(Math.abs(e)),i=o.numbers[r];this.options.simplifyPluralSuffix&&2===o.numbers.length&&1===o.numbers[0]&&(2===i?i="plural":1===i&&(i=""));var a=function(){return n.options.prepend&&i.toString()?n.options.prepend+i.toString():i.toString()};return"v1"===this.options.compatibilityJSON?1===i?"":"number"==typeof i?"_plural_"+i.toString():a():"v2"===this.options.compatibilityJSON||2===o.numbers.length&&1===o.numbers[0]?a():2===o.numbers.length&&1===o.numbers[0]?a():this.options.prepend&&r.toString()?this.options.prepend+r.toString():r.toString()}return this.logger.warn("no plural rule found for: "+t),""},t}(),I=function(){function e(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};S(this,e),this.logger=C.create("interpolator"),this.init(t,!0)}return e.prototype.init=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},e=arguments[1];e&&(this.options=t,this.format=t.interpolation&&t.interpolation.format||function(t){return t},this.escape=t.interpolation&&t.interpolation.escape||l),t.interpolation||(t.interpolation={escapeValue:!0});var n=t.interpolation;this.escapeValue=void 0===n.escapeValue||n.escapeValue,this.prefix=n.prefix?s(n.prefix):n.prefixEscaped||"{{",this.suffix=n.suffix?s(n.suffix):n.suffixEscaped||"}}",this.formatSeparator=n.formatSeparator?n.formatSeparator:n.formatSeparator||",",this.unescapePrefix=n.unescapeSuffix?"":n.unescapePrefix||"-",this.unescapeSuffix=this.unescapePrefix?"":n.unescapeSuffix||"",this.nestingPrefix=n.nestingPrefix?s(n.nestingPrefix):n.nestingPrefixEscaped||s("$t("),this.nestingSuffix=n.nestingSuffix?s(n.nestingSuffix):n.nestingSuffixEscaped||s(")"),this.resetRegExp()},e.prototype.reset=function(){this.options&&this.init(this.options)},e.prototype.resetRegExp=function(){var t=this.prefix+"(.+?)"+this.suffix;this.regexp=new RegExp(t,"g");var e=""+this.prefix+this.unescapePrefix+"(.+?)"+this.unescapeSuffix+this.suffix;this.regexpUnescape=new RegExp(e,"g");var n=this.nestingPrefix+"(.+?)"+this.nestingSuffix;this.nestingRegexp=new RegExp(n,"g")},e.prototype.interpolate=function(e,n,o){function r(t){return t.replace(/\$/g,"$$$$")}var a=this,s=void 0,l=void 0,u=function(t){if(t.indexOf(a.formatSeparator)<0)return i(n,t);var e=t.split(a.formatSeparator),r=e.shift().trim(),s=e.join(a.formatSeparator).trim();return a.format(i(n,r),s,o)};for(this.resetRegExp();s=this.regexpUnescape.exec(e);)l=u(s[1].trim()),e=e.replace(s[0],l),this.regexpUnescape.lastIndex=0;for(;s=this.regexp.exec(e);)l=u(s[1].trim()),"string"!=typeof l&&(l=t(l)),l||(this.logger.warn("missed to pass in variable "+s[1]+" for interpolating "+e),l=""),l=r(this.escapeValue?this.escape(l):l),e=e.replace(s[0],l),this.regexp.lastIndex=0;return e},e.prototype.nest=function(e,n){function o(t){if(t.indexOf(",")<0)return t;var e=t.split(",");t=e.shift();var n=e.join(",");n=this.interpolate(n,s),n=n.replace(/'/g,'"');try{s=JSON.parse(n)}catch(e){this.logger.error("failed parsing options string in nesting for key "+t,e)}return t}var r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{},i=void 0,a=void 0,s=k({},r);for(s.applyPostProcessor=!1;i=this.nestingRegexp.exec(e);){if(a=n(o.call(this,i[1].trim()),s),a&&i[0]===e&&"string"!=typeof a)return a;"string"!=typeof a&&(a=t(a)),a||(this.logger.warn("missed to resolve "+i[1]+" for nesting "+e),a=""),e=e.replace(i[0],a),this.regexp.lastIndex=0}return e},e}(),F=function(t){function e(n,o,r){var i=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{};S(this,e);var a=O(this,t.call(this));return a.backend=n,a.store=o,a.services=r,a.options=i,a.logger=C.create("backendConnector"),a.state={},a.queue=[],a.backend&&a.backend.init&&a.backend.init(r,i.backend,i),a}return w(e,t),e.prototype.queueLoad=function(t,e,n){var o=this,r=[],i=[],a=[],s=[];return t.forEach(function(t){var n=!0;e.forEach(function(e){var a=t+"|"+e;o.store.hasResourceBundle(t,e)?o.state[a]=2:o.state[a]<0||(1===o.state[a]?i.indexOf(a)<0&&i.push(a):(o.state[a]=1,n=!1,i.indexOf(a)<0&&i.push(a),r.indexOf(a)<0&&r.push(a),s.indexOf(e)<0&&s.push(e)))}),n||a.push(t)}),(r.length||i.length)&&this.queue.push({pending:i,loaded:{},errors:[],callback:n}),{toLoad:r,pending:i,toLoadLanguages:a,toLoadNamespaces:s}},e.prototype.loaded=function(t,e,n){var o=this,i=t.split("|"),a=L(i,2),s=a[0],l=a[1];e&&this.emit("failedLoading",s,l,e),n&&this.store.addResourceBundle(s,l,n),this.state[t]=e?-1:2,this.queue.forEach(function(n){r(n.loaded,[s],l),y(n.pending,t),e&&n.errors.push(e),0!==n.pending.length||n.done||(o.emit("loaded",n.loaded),n.done=!0,n.errors.length?n.callback(n.errors):n.callback())}),this.queue=this.queue.filter(function(t){return!t.done})},e.prototype.read=function(t,e,n){var o=arguments.length>3&&void 0!==arguments[3]?arguments[3]:0,r=this,i=arguments.length>4&&void 0!==arguments[4]?arguments[4]:250,a=arguments[5];return t.length?this.backend[n](t,e,function(s,l){return s&&l&&o<5?void setTimeout(function(){r.read.call(r,t,e,n,o+1,2*i,a)},i):void a(s,l)}):a(null,{})},e.prototype.load=function(t,e,n){var o=this;if(!this.backend)return this.logger.warn("No backend was added via i18next.use. Will not load resources."),n&&n();var r=k({},this.backend.options,this.options.backend);"string"==typeof t&&(t=this.services.languageUtils.toResolveHierarchy(t)),"string"==typeof e&&(e=[e]);var a=this.queueLoad(t,e,n);return a.toLoad.length?void(r.allowMultiLoading&&this.backend.readMulti?this.read(a.toLoadLanguages,a.toLoadNamespaces,"readMulti",null,null,function(t,e){t&&o.logger.warn("loading namespaces "+a.toLoadNamespaces.join(", ")+" for languages "+a.toLoadLanguages.join(", ")+" via multiloading failed",t),!t&&e&&o.logger.log("successfully loaded namespaces "+a.toLoadNamespaces.join(", ")+" for languages "+a.toLoadLanguages.join(", ")+" via multiloading",e),a.toLoad.forEach(function(n){var r=n.split("|"),a=L(r,2),s=a[0],l=a[1],u=i(e,[s,l]);if(u)o.loaded(n,t,u);else{var c="loading namespace "+l+" for language "+s+" via multiloading failed";o.loaded(n,c),o.logger.error(c)}})}):a.toLoad.forEach(function(t){o.loadOne(t)})):(a.pending.length||n(),null)},e.prototype.reload=function(t,e){var n=this;this.backend||this.logger.warn("No backend was added via i18next.use. Will not load resources.");var o=k({},this.backend.options,this.options.backend);"string"==typeof t&&(t=this.services.languageUtils.toResolveHierarchy(t)),"string"==typeof e&&(e=[e]),o.allowMultiLoading&&this.backend.readMulti?this.read(t,e,"readMulti",null,null,function(o,r){o&&n.logger.warn("reloading namespaces "+e.join(", ")+" for languages "+t.join(", ")+" via multiloading failed",o),!o&&r&&n.logger.log("successfully reloaded namespaces "+e.join(", ")+" for languages "+t.join(", ")+" via multiloading",r),t.forEach(function(t){e.forEach(function(e){var a=i(r,[t,e]);if(a)n.loaded(t+"|"+e,o,a);else{var s="reloading namespace "+e+" for language "+t+" via multiloading failed";n.loaded(t+"|"+e,s),n.logger.error(s)}})})}):t.forEach(function(t){e.forEach(function(e){n.loadOne(t+"|"+e,"re")})})},e.prototype.loadOne=function(t){var e=this,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",o=t.split("|"),r=L(o,2),i=r[0],a=r[1];this.read(i,a,"read",null,null,function(o,r){o&&e.logger.warn(n+"loading namespace "+a+" for language "+i+" failed",o),!o&&r&&e.logger.log(n+"loaded namespace "+a+" for language "+i,r),e.loaded(t,o,r)})},e.prototype.saveMissing=function(t,e,n,o){this.backend&&this.backend.create&&this.backend.create(t,e,n,o),t&&t[0]&&this.store.addResource(t[0],e,n,o)},e}(R),D=function(t){function e(n,o,r){var i=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{};S(this,e);var a=O(this,t.call(this));return a.cache=n,a.store=o,a.services=r,a.options=i,a.logger=C.create("cacheConnector"),a.cache&&a.cache.init&&a.cache.init(r,i.cache,i),a}return w(e,t),e.prototype.load=function(t,e,n){var o=this;if(!this.cache)return n&&n();var r=k({},this.cache.options,this.options.cache),i="string"==typeof t?this.services.languageUtils.toResolveHierarchy(t):t;r.enabled?this.cache.load(i,function(t,e){if(t&&o.logger.error("loading languages "+i.join(", ")+" from cache failed",t),e)for(var r in e)if(Object.prototype.hasOwnProperty.call(e,r))for(var a in e[r])if(Object.prototype.hasOwnProperty.call(e[r],a)&&"i18nStamp"!==a){var s=e[r][a];s&&o.store.addResourceBundle(r,a,s)}n&&n()}):n&&n()},e.prototype.save=function(){this.cache&&this.options.cache&&this.options.cache.enabled&&this.cache.save(this.store.data)},e}(R),K=function(t){function e(){var n=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},o=arguments[1];S(this,e);var r=O(this,t.call(this));if(r.options=b(n),r.services={},r.logger=C,r.modules={external:[]},o&&!r.isInitialized&&!n.isClone){var i;if(!r.options.initImmediate)return i=r.init(n,o),O(r,i);setTimeout(function(){r.init(n,o)},0)}return r}return w(e,t),e.prototype.init=function(t,e){function n(t){return t?"function"==typeof t?new t:t:null}var o=this;if("function"==typeof t&&(e=t,t={}),t||(t={}),"v1"===t.compatibilityAPI?this.options=k({},v(),b(c(t)),{}):"v1"===t.compatibilityJSON?this.options=k({},v(),b(p(t)),{}):this.options=k({},v(),this.options,b(t)),this.format=this.options.interpolation.format,e||(e=m),!this.options.isClone){this.modules.logger?C.init(n(this.modules.logger),this.options):C.init(null,this.options);var r=new _(this.options);this.store=new A(this.options.resources,this.options);var i=this.services;i.logger=C,i.resourceStore=this.store,i.resourceStore.on("added removed",function(t,e){i.cacheConnector.save()}),i.languageUtils=r,i.pluralResolver=new V(r,{prepend:this.options.pluralSeparator,compatibilityJSON:this.options.compatibilityJSON,simplifyPluralSuffix:this.options.simplifyPluralSuffix}),i.interpolator=new I(this.options),i.backendConnector=new F(n(this.modules.backend),i.resourceStore,i,this.options),i.backendConnector.on("*",function(t){for(var e=arguments.length,n=Array(e>1?e-1:0),r=1;r<e;r++)n[r-1]=arguments[r];o.emit.apply(o,[t].concat(n))}),i.backendConnector.on("loaded",function(t){i.cacheConnector.save()}),i.cacheConnector=new D(n(this.modules.cache),i.resourceStore,i,this.options),i.cacheConnector.on("*",function(t){for(var e=arguments.length,n=Array(e>1?e-1:0),r=1;r<e;r++)n[r-1]=arguments[r];o.emit.apply(o,[t].concat(n))}),this.modules.languageDetector&&(i.languageDetector=n(this.modules.languageDetector),i.languageDetector.init(i,this.options.detection,this.options)),this.translator=new M(this.services,this.options),
this.translator.on("*",function(t){for(var e=arguments.length,n=Array(e>1?e-1:0),r=1;r<e;r++)n[r-1]=arguments[r];o.emit.apply(o,[t].concat(n))}),this.modules.external.forEach(function(t){t.init&&t.init(o)})}var a=["getResource","addResource","addResources","addResourceBundle","removeResourceBundle","hasResourceBundle","getResourceBundle"];a.forEach(function(t){o[t]=function(){var e;return(e=o.store)[t].apply(e,arguments)}}),"v1"===this.options.compatibilityAPI&&g(this);var s=function(){o.changeLanguage(o.options.lng,function(t,n){o.isInitialized=!0,o.logger.log("initialized",o.options),o.emit("initialized",o.options),e(t,n)})};return this.options.resources||!this.options.initImmediate?s():setTimeout(s,0),this},e.prototype.loadResources=function(){var t=this,e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:m;if(this.options.resources)e(null);else{if(this.language&&"cimode"===this.language.toLowerCase())return e();var n=[],o=function(e){if(e){var o=t.services.languageUtils.toResolveHierarchy(e);o.forEach(function(t){n.indexOf(t)<0&&n.push(t)})}};if(this.language)o(this.language);else{var r=this.services.languageUtils.getFallbackCodes(this.options.fallbackLng);r.forEach(function(t){return o(t)})}this.options.preload&&this.options.preload.forEach(function(t){return o(t)}),this.services.cacheConnector.load(n,this.options.ns,function(){t.services.backendConnector.load(n,t.options.ns,e)})}},e.prototype.reloadResources=function(t,e){t||(t=this.languages),e||(e=this.options.ns),this.services.backendConnector.reload(t,e)},e.prototype.use=function(t){return"backend"===t.type&&(this.modules.backend=t),"cache"===t.type&&(this.modules.cache=t),("logger"===t.type||t.log&&t.warn&&t.error)&&(this.modules.logger=t),"languageDetector"===t.type&&(this.modules.languageDetector=t),"postProcessor"===t.type&&T.addPostProcessor(t),"3rdParty"===t.type&&this.modules.external.push(t),this},e.prototype.changeLanguage=function(t,e){var n=this,o=function(t,o){o&&(n.emit("languageChanged",o),n.logger.log("languageChanged",o)),e&&e(t,function(){return n.t.apply(n,arguments)})},r=function(t){t&&(n.language=t,n.languages=n.services.languageUtils.toResolveHierarchy(t),n.translator.changeLanguage(t),n.services.languageDetector&&n.services.languageDetector.cacheUserLanguage(t)),n.loadResources(function(e){o(e,t)})};t||!this.services.languageDetector||this.services.languageDetector.async?!t&&this.services.languageDetector&&this.services.languageDetector.async?this.services.languageDetector.detect(r):r(t):r(this.services.languageDetector.detect())},e.prototype.getFixedT=function(t,e){var n=this,o=function t(e){var o=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},r=k({},o);return r.lng=r.lng||t.lng,r.lngs=r.lngs||t.lngs,r.ns=r.ns||t.ns,n.t(e,r)};return"string"==typeof t?o.lng=t:o.lngs=t,o.ns=e,o},e.prototype.t=function(){var t;return this.translator&&(t=this.translator).translate.apply(t,arguments)},e.prototype.exists=function(){var t;return this.translator&&(t=this.translator).exists.apply(t,arguments)},e.prototype.setDefaultNamespace=function(t){this.options.defaultNS=t},e.prototype.loadNamespaces=function(t,e){var n=this;return this.options.ns?("string"==typeof t&&(t=[t]),t.forEach(function(t){n.options.ns.indexOf(t)<0&&n.options.ns.push(t)}),void this.loadResources(e)):e&&e()},e.prototype.loadLanguages=function(t,e){"string"==typeof t&&(t=[t]);var n=this.options.preload||[],o=t.filter(function(t){return n.indexOf(t)<0});return o.length?(this.options.preload=n.concat(o),void this.loadResources(e)):e()},e.prototype.dir=function(t){if(t||(t=this.languages&&this.languages.length>0?this.languages[0]:this.language),!t)return"rtl";var e=["ar","shu","sqr","ssh","xaa","yhd","yud","aao","abh","abv","acm","acq","acw","acx","acy","adf","ads","aeb","aec","afb","ajp","apc","apd","arb","arq","ars","ary","arz","auz","avl","ayh","ayl","ayn","ayp","bbz","pga","he","iw","ps","pbt","pbu","pst","prp","prd","ur","ydd","yds","yih","ji","yi","hbo","men","xmn","fa","jpr","peo","pes","prs","dv","sam"];return e.indexOf(this.services.languageUtils.getLanguagePartFromCode(t))>=0?"rtl":"ltr"},e.prototype.createInstance=function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},n=arguments[1];return new e(t,n)},e.prototype.cloneInstance=function(){var t=this,n=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},o=arguments.length>1&&void 0!==arguments[1]?arguments[1]:m,r=k({},this.options,n,{isClone:!0}),i=new e(r,o),a=["store","services","language"];return a.forEach(function(e){i[e]=t[e]}),i.translator=new M(i.services,i.options),i.translator.on("*",function(t){for(var e=arguments.length,n=Array(e>1?e-1:0),o=1;o<e;o++)n[o-1]=arguments[o];i.emit.apply(i,[t].concat(n))}),i.init(r,o),i},e}(R),q=new K;return q});