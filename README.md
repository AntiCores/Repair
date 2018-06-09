<img src="https://github.com/JackMD/Repair/blob/master/meta/Repair.png" width="150" height= "150">

# Repair

| HitCount | License | Poggit | Release |
|:--:|:--:|:--:|:--:|
|[![HitCount](http://hits.dwyl.io/JackMD/Repair.svg)](http://hits.dwyl.io/JackMD/Repair)|[![GitHub license](https://img.shields.io/github/license/JackMD/Repair.svg)](https://github.com/JackMD/Repair/blob/master/LICENSE)|[![Poggit-CI](https://poggit.pmmp.io/ci.shield/JackMD/Repair/Repair)](https://poggit.pmmp.io/ci/JackMD/Repair/Repair)|[![](https://poggit.pmmp.io/shield.state/Repair)](https://poggit.pmmp.io/p/Repair)|

### A Repair plugin for PocketMine-MP // McPe 1.2
### Features:
 - Repair the items in your hand.
 - Repair all the items in your inventory.
 - Repair items using commands.
 - Repair items using signs as well.
### How to setup?
 - Get the [.phar](https://poggit.pmmp.io/ci/JackMD/Repair/Repair) and drop the into your `plugins` folder.
 - Start the server.
 - You can either use commands or signs to repair your items.
### FAQs:
**Q: What is the command to repair the item?**<br />
A: Use `/repair hand` to repair the item in your hand.<br /><br />
**Q: Can I repair multiple items at once?**<br />
A: Yes you can. Simply use `/repair all` to repair all the items in your inventory.<br /><br />
**Q: I found a issue in the plugin what do I do?**<br />
A: Please open an issue [here](https://github.com/JackMD/Repair/issues) and give as much detail as possible.<br /><br />
**Q: How to use repair signs?**<br />
A: Place down a sign and write `[repair]` in first line and write `hand` or `all` in the second line. Remember `hand` will repair the item in your hand whereas `all` will repair the all the items in your inventory.
### Commands and Permissions:
|Description|Command|Permission|Default|
|:--:|:--:|:--:|:--:|
|Repair|`/repair`|`repair.command.use`|`op`|
|Repair Hand|`/repair hand`|`repair.command.use.hand`|`op`|
|Repair All|`/repair all`|`repair.command.use.all`|`op`|
|Repair Hand Sign|`~`|`repair.sign.use.hand`|`op`|
|Repair All Sign|`~`|`repair.sign.use.all`|`op`|
|Place a Sign|`~`|`repair.sign.place`|`op`|
|Create a Sign|`~`|`repair.sign.create`|`op`|
|Break a Sign|`~`|`repair.sign.break`|`op`|

### Info:
  - Make sure to subscribe to be updated for when i release more stuff on my [YT](https://youtu.be/x_mc-ocrdDU) channel.
  - Support is appreciated.
  - Please don't hesitate to ask questions or report bug report in issues section.
### Disclaimer:

```
YouTubers are not at all allowed to showcase this plugin in their videos.
If found doing so I will copyright claim your videos there and then.

This software is licensed under "GNU General Public License v3.0".
This license allows you to use it and/or modify it but you are not at
all allowed to sell this plugin at any cost. If found doing so the
necessary action required would be taken. Further removal of the License and or
authors name from this software is strictly prohibited.
```
