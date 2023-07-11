const express = require('express');
const cors = require('cors');
const mqtt = require('mqtt');
const mysql = require('mysql');

const app = express();

const con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "wbms_db"
  });

  con.connect();

const options = {
    host: '5883c067e811428892fe56aba1fce901.s1.eu.hivemq.cloud',
    port: 8883,
    protocol: 'mqtts',
    username: 'water_meter',
    password: 'Devpass2022'
}

const client = mqtt.connect(options);

const corsOptions = {
    origin: "*",
    optionsSuccessStatus: 200,
};

app.use(cors(corsOptions));

app.get('/pump/1', (req, res, next) => {
    client.publish('water_meter/activate', 'turn on')
    res.status(201).send('Turned on')
});

app.get('/pump/0', (req, res, next) => {
    client.publish('water_meter/deactivate', 'turn off');
    res.status(201).send('Turned off')
});
app.listen('3000', () => {
    console.log('App started');
});

// Listen for new data and post them

//setup the callbacks
client.on('connect', function () {
    console.log('Connected');
});

client.on('error', function (error) {
    console.log(error);
});


client.on('message', function (topic, message) {
    //Called each time a message is received
    console.log('Received message:', topic, message.toString());

    if(topic === 'water_meter/report'){
        // rate
        // total volume
        // unit
        // client id
        const {totalLitres, token, flowRate, clientId} = JSON.parse(message.toString());

        const client_id = clientId;
        const reading = totalLitres;
        const previous = 0;
        const rate = flowRate;
        const total = 1600 * reading;
        const status = 0;

        console.log(total);

        const sql = `INSERT INTO billing_list (client_id, reading, previous, rate, total, status) VALUES (${client_id}, ${reading}, ${previous}, ${rate}, ${total}, ${status})`;
        con.query(sql, function (err, result) {
        if (err) throw err;
        console.log("1 record inserted");
        });
    }
});

const turnOffPump = () => {
    client.publish('water_meter/deactivate', 1, {retain: true})}

const turnOnPump = () => {
    client.publish('water_meter/deactivate', 0, {retain: true})
}

// subscribe to topic 'my/test/topic'
client.subscribe('water_meter/activate');
client.subscribe('water_meter/deactivate');
client.subscribe('water_meter/report');
