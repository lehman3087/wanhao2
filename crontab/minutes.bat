	@echo off
mshta vbscript:createobject("wscript.shell").run("""iexplore"" http://localhost/crontab/cj_index.php?act=minutes",0)(window.close) 
echo 1
ping 127.0.0.1 -n 5
taskkill /f /im iexplore.exe 