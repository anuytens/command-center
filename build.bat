@echo off
call lessc -o public/css/main.less public/css/main.min.css
call r.js.cmd -o name=main out=public/js/main.min.js baseUrl=public/js paths.requireLib=../components/requirejs/require include=requireLib
call git add *
call git tag -a vX.X.X -m "Version X.X.X"
call git push origin vX.X.X