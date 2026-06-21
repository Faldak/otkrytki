@echo off
echo Запуск toigakel сервера...
echo Откройте браузер: http://localhost:8080
echo Для остановки нажмите Ctrl+C
echo.
cd /d "%~dp0"
php -S localhost:8080
pause
