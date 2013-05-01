@echo off
call lessc -x public/css/main.less public/css/main.min.css
call r.js.cmd -o name=js/main out=public/js/main.min.js baseUrl=public paths.requireLib=components/requirejs/require include=requireLib
call git add *
call git tag -a vX.X.X -m "Version X.X.X"
call git push origin vX.X.X