# Philips Hue Remote PHP API
A simple PHP wrapper to allow control of your Philips Hue Bridge from anywhere!

## Installation
1. Copy `PhilipsHue.php` to your working directory
2. `require` or `include` `PhilipsHue.php`
3. ???
4. Profit.

## Usage
You'll need two things to get your Bridge up and running:

### Bridge ID
This can be retreived by logging in to [My hue](https://my.meethue.com/en-us/), going to [this page](https://www.meethue.com/en-us/user/bridge) and clicking **More bridge details**.

### Authentication Token
This can be retrieved by navigating to the following link (**be sure to fill in your bridge ID**):

`http://www.meethue.com/en-US/api/gettoken?deviceid=` **&lt;BRIDGE ID&gt;** `&devicename=iPhone+5&appid=hueapp`

Click '*Yes*', then **copy the link** from the '*Back to the App*' button (**do not click it**). This will give you something like the following:

`phhueapp://sdk/login/3jExmQ1pxQk1FT5Dekx01YX9HUc1dkbG53VHpBOGVOcUpSUMHa085Wmc4T0=`

Simply remove `phhueapp://sdk/login/` and you have your token!

### Initialization
When you have everything you need, simply initialize the class like so:

    $BridgeID	= "0000000000000000";
    $APIToken	= "0hKbFRkR0Y250SlJhcNUlkkBHNmxaUTNG4ZbXVSTHhLazkrNFpXMWVSYMD0=";

    $Bridge		= new PhilipsHue($BridgeID, $APIToken);

Retrieving the status of your bridge, including a list of all of your connected bulbs, is just as simple (be sparing with this function as it is quite heavy on the Hue Bridge's CPU):

    $Status = $Bridge->getBridge();

You can send commands to your bridge like this:

    $Bridge->sendCommand('lights/1/status', array("on" => true));

## Commands
Hue commands consist of a URL and an array payload. The URL tells the bridge what type of action to perform to which bulb, and the payload tells it exactly what to do with the bulb.

For example, the following command will set bulb number 3's brightness to 100%:

    $Bridge->sendCommand('lights/3/status', array("bri" => 255));

Below is a list of available payload arguments for the `status` command, which is realistically the only command type you will need to access.

| Parameter | Acceptable Values | Effect |
| --------- | ----------------- | ------ |
| on | *(bool)* **true** or **false** | Turns the bulb on (true) or off (false). |
| bri | *(int)* 0 - 255 | Sets the bulb's brightness. 0 is the dimmest, 255 is the brightest. |
| hue | *(int)* 0 - 65535 | Sets the bulb's colour value. *More information to come - will experiment with this and post my findings.* |
| sat | *(int)* 0 - 255 | Sets the saturation of the colour. 0 is white, 255 is full colour. |

*More to come...*
