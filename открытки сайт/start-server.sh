#!/bin/bash
echo "Запуск toigakel сервера..."
echo "Откройте браузер: http://localhost:8080"
echo "Для остановки нажмите Ctrl+C"
echo ""
cd "$(dirname "$0")"
php -S localhost:8080
