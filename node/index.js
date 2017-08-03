let articleMap = require('./articleMap'),
    pdfBuilder = require('./pdfBuilder');

let map = new articleMap();
map.build();

let builder = new pdfBuilder();
builder.build();
