# oc7

## Issues

Start: 240301

### 1. install symfony #4 (240302)

- create repository
- create project symfony for api
- connect it to the repo
- install builder for makes
- install orm-pack
- install database
- create user
- migrate database

###  fixtures #6

- create database.json of references for the project (240303)
- create the Uml model of datas
- create set of related entities Device, Prop, Attr, DeviceProp (240304)
- create the transformer of simple json to 4 linked tables for fixtures (240305)
- make working a request through mappers (240306)
- create Uml of usage, sequence and class

### consultation #8

- consult the details of a BileMo product;
- reset structure of tables
- add mapping for Apis (avoid circular defs and displays url instead of datas)
- mappers are unuseful
- build set of tables for users
- consult client then users
- consult devices, then props, then attr

### renew #10

- reset config without apiPlatform

### cleanup #12

- delete unused files

### auth #14

- token-auth using jwt
- config jwt
- add cache system to devices and users

### crud #16 

- add a new user linked to a customer
- del user
- update user

### exceptions #18

- display errors in json

### hateoas #20

- display errors in json

