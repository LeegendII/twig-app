@echo off
echo Starting PHP development server...
cd /d "C:\xampp\htdocs\my project"
start "PHP Server" cmd /k "C:\xampp\php\php.exe -S localhost:8000 -t public/"
timeout /t 2 >nul
echo Opening browser...
start http://localhost:8000
echo Project is running at http://localhost:8000
pause