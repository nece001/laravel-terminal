(function(){!function(n,r,t){var e,o,_,u,i,a,c,s,p;return a=function(n,r){return n=n.replace("[","&#91;").replace("]","&#93;"),"[[;"+r+";]"+n+"]"},u=function(n){return a(n,"#008400")},e=function(n){return a(n,"#a50")},_={copyright:[" __                        _    _____              _         _ ","|  |   ___ ___ ___ _ _ ___| |  |_   ____ ___ _____|_|___ ___| |","|  |__| .'|  _| .'| | | -_| |    | || -_|  _|     | |   | .'| |","|_____|__,|_| |__,|\\_/|___|_|    |_||___|_| |_|_|_|_|_|_|__,|_|","","Copyright (c) 2015 Recca Tsai <http://phpwrite.blogspot.tw/>",""].join("\n"),production:["",e("**************************************"),e("*     Application In Production!     *"),e("**************************************"),""].join("\n")},c=function(){var r;return r={},function(t,e,o,_){return r[t]=r[t]||0,e.pause(),n.ajax({url:t,dataType:"json",type:"post",data:{jsonrpc:"2.0",method:o,params:_,id:++r[t]}}).success(function(n){return n.result===!1?e.error(n.error):e.echo(n.result)}).error(function(n,r,t){return e.error(t)}).complete(function(){return e.resume()})}}(),p=function(){var r;return r=function(n){switch(n.toLowerCase()){case"y":case"yes":return!0;default:return!1}},function(t,e,o){var _;return null==e&&(e=""),null==o&&(o=">"),_=n.Deferred(),""!==e&&t.echo(e),t.push(function(n){_.resolve(r(n)),t.pop()},{prompt:o}),_.promise()}}(),s=function(n,r){return 0===n.indexOf(r)},i=function(n,r,t,e,o){return null==e&&(e=function(){}),n===t?(o||(o=t),r.push(function(n){e(o,n,r)},{prompt:o+">"}),!0):!1},o=function(r,t,o){var i,a,l,f;return i=n.terminal.parseCommand(r.trim()),i.name===o?(a=Terminal.endpoint[o],f=i.args,l=f.shift()||"list","artisan"===o&&"production"===Terminal.environment&&-1===n.inArray("--force",f)&&(s(l,"migrate")===!0&&s(l,"migrate:status")===!1||s(l,"db:seed")===!0)?p(t,""+_.production,u("Do you really wish to run this command? [y/N] (yes/no)")+" ["+e("no")+"]: ").done(function(n){return n===!0?(f.push("--force"),c(a,t,l,f)):t.echo("\n"+e("Command Cancelled!"))}):c(a,t,l,f),!0):!1},n(t.body).terminal(function(n,r){""!==n&&i(n,r,"mysql",function(n,r,t){var e;return e=Terminal.endpoint[n],c(e,t,r,[])})!==!0&&i(n,r,"artisan tinker",function(n,r,t){var e;return e=Terminal.endpoint[n],c(e,t,r,[])},"tinker")!==!0&&(o(n,r,"artisan")||r.error("Command '"+n+"' Not Found!"))},{greetings:_.copyright,onBlur:function(){return!1}})}(jQuery,window,document)}).call(this);