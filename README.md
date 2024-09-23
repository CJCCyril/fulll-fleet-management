# fulll-fleet-management

## Requirements

>Docker engine
> 
>Docker compose

## Setup

`make first-start`

## Usage

##### Create a new fleet:

```
make fleet-create userId=[userId]

make fleet-create userId=JohnDoe
```

##### Create or find and register a vehicle into the fleet:

```
make fleet-register-vehicle fleetId=[fleetId] vehiclePlateNumber=[vehiclePlateNumber]

make fleet-register-vehicle fleetId=1 vehiclePlateNumber=GG-123-WP
```

##### Park a vehicle to a location:

```
make fleet-park-vehicle vehiclePlateNumber=[vehiclePlateNumber] lat=[lat] lng=[lng] (alt=[alt])

make fleet-park-vehicle vehiclePlateNumber=GG-123-WP lat=43.455252 lng=5.475261
```

Use `make` to see the list of available commands
