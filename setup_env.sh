#!/bin/bash
read -p 'Enter your telegram bot token: ' BOT_TOKEN
read -p 'Enter webhook url: ' WEBHOOK_URL

echo 'TELEGRAM_BOT_TOKEN="'$BOT_TOKEN'"' > .env
echo 'TELEGRAM_WEBHOOK="'$WEBHOOK_URL'"' >> .env
echo Written info to .env
