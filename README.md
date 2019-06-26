# ApaLogger
In past I always used `ceye` as my web logger, but it usually crashed... some of other's web logger on github which is used for AWD also has a complex interface. Therefore, I write my own web logger which simply shows the all http requests. If you are interested in using it, please read the documentation in following carefully.  

## Requirement ☑️
* Ubuntu + apache2 + PHP  
This is the web logger of Apache  
* [mod_dumpost](https://github.com/danghvu/mod_dumpost)  
This is the module for apache2 to dump the POST log. In default, apache2 only store the get log in `/var/log/apache2/access.log` because some POST data would be so big to be showed in log, such as img. With this module, I can store the limited size of POST data to the location I want.  

## Customize your own log.php ✏️
* [GET log](https://github.com/shinmao/ApaLogger/blob/master/log.php#L60)  
This is the path for the GET log. `/var/log/apache2/access.log` is the default path, you would need to change this line if your path of GET log has been changed.  
* [POST log](https://github.com/shinmao/ApaLogger/blob/master/log.php#L110)  
This is the path for the POST log. With module of `mod_dumpost`, I set my location of POST log as `/var/log/apache2/post_log`. However, if you don't set your own path with the module, it would store in the `error.log` by default; what's worse, the log format would be messed up (I would get into the detail in next point).  
* [regular expression](https://github.com/shinmao/ApaLogger/blob/master/log.php#L114)  
Just like shown in this line, I use specific regex the parse the log format. For the **GET log**, if you change the default log format, it would also be messed up. For the **POST log**, if you put it into the file of `error_log` or other kinds of existing file, it would also be messed up.  

**Of course, you need permission to read the log file!!**

### That's all, come to enjoy ApaLogger 👍
![](https://github.com/shinmao/ApaLogger/blob/master/screenshot.png)
* Layout: Bootstrap  
* Log count: the number of GET log and POST log you want to show  
* The first part is GET log and the second part is POST log.

Put it on your apache server and it works. Any bug found or suggestion can email ✉️ rafaelchen@protonmail.com 
