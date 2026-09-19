@echo off
REM ============================================================
REM InfinityFree Deployment Preparation Script
REM Run this BEFORE uploading files via FTP
REM ============================================================
echo.
echo ====================================================
echo  3YOS Catering - InfinityFree Deployment Prep
echo ====================================================
echo.

REM Step 1: Copy storage files to public/storage (replaces symlink)
echo [1/4] Copying storage files to public/storage...
if exist "public\storage" (
    rmdir /s /q "public\storage"
)
xcopy "storage\app\public" "public\storage" /E /I /Y /Q
echo       Done.

REM Step 2: Copy production .env
echo [2/4] Setting up production .env...
if exist ".env.production" (
    copy /Y ".env.production" ".env.deploy"
    echo       Created .env.deploy (rename to .env on server)
) else (
    echo       WARNING: .env.production not found!
)

REM Step 3: Create required storage directories
echo [3/4] Ensuring storage directories exist...
if not exist "storage\framework\cache\data" mkdir "storage\framework\cache\data"
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions"  
if not exist "storage\framework\views" mkdir "storage\framework\views"
if not exist "storage\logs" mkdir "storage\logs"
echo       Done.

REM Step 4: Generate file list for FTP upload
echo [4/4] Generating upload file list...
echo.
echo ====================================================
echo  READY FOR FTP UPLOAD
echo ====================================================
echo.
echo Upload ALL files EXCEPT:
echo   - node_modules/
echo   - .git/
echo   - tests/
echo   - .env (use .env.deploy renamed as .env)
echo   - .env.example
echo   - .env.production
echo   - deploy-infinityfree.bat
echo   - vite.config.js
echo   - package.json
echo   - package-lock.json
echo   - phpunit.xml
echo   - .phpunit.result.cache
echo.
echo Upload TO: htdocs/ on your InfinityFree FTP
echo.
echo AFTER uploading:
echo   1. Rename .env.deploy to .env on the server
echo   2. Edit .env with your actual DB credentials
echo   3. Import infinityfree_database.sql via phpMyAdmin
echo   4. Visit your site URL to test
echo.
pause
