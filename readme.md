
LogInfo
==========

Log Info and stats for syslog, apachelog, etc..


* Free software: Apache license 2.0


Features
--------

* artisan logsinfo:show --a --t=apachelog

<img alt="Cli" src="docs/cli.png?raw=true" width="400">

* artisan logsinfo:send --a --t=syslog

<img alt="Cli" src="docs/mail.png?raw=true" width="400">

* artisan serve
* http://localhost:8000/?type=apachelog&field=code

{
  "data": [
    {
      "name": "404",
      "count": 3,
      "percent": "75 %"
    },
    {
      "name": "200",
      "count": 1,
      "percent": "25 %"
    }
  ],
  "links": {
    "self": "/"
  }
}
