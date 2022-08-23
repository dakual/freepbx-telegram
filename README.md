> nano /etc/asterisk/extensions_custom.conf 
```
[telegram]
exten => s,1,NoOp(Entering user defined context)
exten => s,n,AGI(telegram.php,${CALLERID(num)}, ${STRFTIME(${EPOCH},,%Y.%m.%d-%H:%M:%S)})
exten => s,n,hangup()
```

> alterntive
```
[telegram]
exten => s,1,NooP(~ Telegram notification ~)
exten => s,n,Set(tg_bot_api_key=1460817223:AAGwTCD1sUKlS_1jrytPYg3PqX6-M_zIFf4)
exten => s,n,Set(tg_chat_id=1582487357)
exten => s,n,Set(tg_message=Please%20call%20back%20me%20${CALLERID(num)})
exten => s,n,Set(tg_url_request=https://api.telegram.org/bot${tg_bot_api_key}/sendMessage?chat_id=${tg_chat_id}&text=${tg_message})
exten => s,n,NooP(${CURL(${tg_url_request})})
```

### Admin > Custom Destinations > +Add Destination. 
```
Target telegram,s,1
Description Telegram notification
```