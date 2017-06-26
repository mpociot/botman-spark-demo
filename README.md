# BotMan + Cisco Spark Demo

This project shows how to use BotMan in combination with Cisco Spark.

## Installation

- Clone this repository.
- `composer install`
- Copy the `.env.example` file to `.env`.
- Create a Cisco Spark Bot and past the access token into your `.env` file.
- Use Laravel Valet or ngrok to create a local tunnel to the folder containing the `index.php` file.
- Create a Cisco Spark Webhook with the created URL:

Just replace `--YOUR-AUTHORIZATION-TOKEN--` with your token and `--YOUR-URL--` with your bot URL.

```bash
curl -X POST -H "Accept: application/json" -H "Authorization: Bearer --YOUR-AUTHORIZATION-TOKEN--" -H "Content-Type: application/json" -d '{
	"name": "BotMan Webhook",
	"targetUrl": "--YOUR-URL--",
	"resource": "all",
	"event": "all"
}' "https://api.ciscospark.com/v1/webhooks"
```

Now you can write your bot. 

To start a conversation, write `pizza`.

See `index.php` and `PizzaConversation.php` for available commands and how conversations work.