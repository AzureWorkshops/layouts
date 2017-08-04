let articleMap = require('./articleMap'),
    pdfBuilder = require('./pdfBuilder'),
    waitUntil = require('wait-until');

let map = new articleMap();
map.build();

let builder = new pdfBuilder();
builder.build();

waitUntil(1000, 300, () => {
    console.log(builder.complete);
    return builder.complete;
}, () => {});