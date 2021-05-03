#!/bin/python
import json
import subprocess
from shutil import copyfile

# Get user input
botToken = input("Enter your telegram bot token: ")
exposeSubdomain = input("(Optional) Enter expose subdomain: ")
if not exposeSubdomain:
	webhookUrl = input("Enter webhook url: ")
else:
	webhookUrl = "https://" + exposeSubdomain + ".sharedwithexpose.com/webhook.php"

# Write .env
if botToken or webhookUrl:
	with open(".env", "w") as envFile:
		if botToken:
			envFile.write("TELEGRAM_BOT_TOKEN=\"" + botToken + "\"\n")
			print("Written bot token to .env")
		
		if webhookUrl:
			envFile.write("TELEGRAM_WEBHOOK=\"" + webhookUrl + "\"\n")
			print("Written webhook URL token to .env")
else:
	print("No token or url specified, skipping writing .env")

# Write composer.json
if exposeSubdomain:
	with open("composer.json.preset", "r") as composerPresetFile:
		composerDict = json.load(composerPresetFile)

		# Replace dev command
		# command runs a php webserver with the public-folder as root, and then exposes it to the internet using expose
		devCommand = "php -S localhost:8080 -t public &>/dev/null & expose share localhost:8080 --subdomain=" + exposeSubdomain
		composerDict["scripts"]["dev"] = devCommand

		# Write to composer.json
		with open("composer.json", "w") as composerFile:
			print("Written dev command to composer.json")
			json.dump(composerDict, composerFile, indent=4)
else:
	# Simply copy the preset file as-is
	copyfile("composer.json.preset", "composer.json")

# Run scripts
runSetup = input("\nWould you like to run composer install and setup.php [Y/n]: ")

if runSetup.lower() != 'n':
	# composer install
	print("Running composer install...")
	try:
		output = subprocess.run(['composer', 'install'], check=True, text=True, stdout=subprocess.PIPE)
		print(output.stdout)
	except subprocess.CalledProcessError:
		print("\nComposer install gave an error. Did you install composer yet? https://getcomposer.org/\nExiting...")
		exit()
	print("Executed composer install successfully")

	# setup.php
	print("Running setup.php...")
	try:
		output = subprocess.run(['php', 'setup.php'], check=True, text=True, stdout=subprocess.PIPE)
		print(output.stdout)
	except subprocess.CalledProcessError:
		print("\nsetup.php gave an error. Is your telegram bot token correct?\nExiting...")
		exit()
	print("Executed setup.php successfully")

# The End
if exposeSubdomain and runSetup.lower != 'n':
	print("\nDone! You can now run `composer run dev` to start the webserver.")
else:
	print("\nDone!")
