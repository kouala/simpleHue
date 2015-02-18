# simpleHue

> simpleHue is a simple API for Philips HUE

### Installation

Before use this API, you should create your user in the bridge.
Please edit the inc.hue.php and fill in the 3 different values:
- $server : IP address of the bridge.
- $user : name of the user autorised in the bridge. Please note: between 10 and 40 characters, alphanumeric.
- $device : name of you device. Please note: between 10 and 40 characters.

Then, include the simpleHue.php file in your PHP file, press the button on your bridge and call the function
```
print_r(CreateUser());
```

Your account was created successfully. Now, you could use the simpleHue API.
