# Wereldbot for Telegram

Simple Telegram bot written in PHP. Can show online players, MOTD and online status of the Dutch Minecraft server, Wereldbouw. You can also subscribe to receive alerts of updates (WIP).

## Getting Started (for developers)

### Requirements

* Telegram account, to create a bot: https://core.telegram.org/bots#6-botfather

### Dependencies

* PHP 7.2+
* [Composer](https://getcomposer.org/)
* (Recommended) [Expose](https://beyondco.de/docs/expose/introduction)
* (Optional) Python 3.5+ (for install script)

### Installing

**Using install script**

* Clone this repository
* Run `projectsetup.py`

**Manually**

1. Clone this repository and enter the directory.
2. Create a `.env` file:

    ```
    TELEGRAM_BOT_TOKEN="<YOUR TOKEN>"
    TELEGRAM_WEBHOOK="<YOUR WEBHOOK>"
    ```
    Note: webhook URL must be HTTPS.
3. Duplicate the `composer.json.preset` file and rename it to composer.json.
4. Run `composer install`.
5. Run `php setup.php`.
6. (Optional) if using expose, change the dev script in `composer.json` to use a subdomain:

    ```json
    "scripts": {
        "dev": "php -S localhost:8080 -t public &>/dev/null & expose share localhost:8080 --subdomain=<YOUR_SUBDOMAIN>"
    }
    ```

### Running

If using expose, run `composer run dev` to start the webserver. Otherwise, just make sure that your webhook is reachable on the internet.

## License

This project is licensed under the [MIT license](./LICENSE.md).

## Acknowledgments

Created using Pretzelhands' tutorial: [Build a Telegram bot in PHP](https://pretzelhands.com/posts/build-a-telegram-bot-in-php)

Source code from the tutorial: https://github.com/pretzelhands/basic-telegram-bot
