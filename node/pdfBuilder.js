let fs = require('fs'),
    path = require('path'),
    find = require('find'),
    async = require('async'),
    pdf = require('html-pdf'),
    merge = require('pdf-merge'),
    Replacer = require('pattern-replace')
docs = require('./docs/config.json');

function pdfBuilder() {
    this.complete = false;

    this.build = function () {
        async.series([
            (cb) => { convert(cb) },
            (cb) => { combine(cb) },
            (cb) => { addLink(cb) }
        ], (err) => {
            if (err) { console.error(err); }

            console.log('Done.');
            this.complete = true;
        });
    }

    function convert(cb) {
        console.log('Converting HTML to PDFs...');
        find.file(/\.html$/, __dirname + '/static', (files) => {
            if (files.length == 0) {
                cb();
            } else {

                let completed = 0;

                for (var i = 0; i < files.length; i++) {
                    let file = files[i];
                    let options = {
                        format: 'Letter',
                        orientation: 'portrait',
                        type: 'pdf',
                        phantomArgs: [
                            '--ignore-ssl-errors=yes'
                        ],
                        border: {
                            top: '.5in',
                            right: '.5in',
                            bottom: '.5in',
                            left: '.5in'
                        }
                    }

                    let html = fs.readFileSync(file).toString()
                        .replace(/(src|(?:[^a]) href)(="|=')((?!(https)|(http)|(\/\/))(\.*\/?)*(\w))([^'"]*)("|')/g, `$1$2file://${__dirname}/static/$8$9$10`)
                        .replace(/(src|href)(="|=')(\/\/)([^'"]*)("|')/g, '$1$2https://$4$5');

                    let fullPath = './tmp' + path.dirname(file).replace(__dirname + '/static', '') + '/' + path.basename(file, '.html') + '.pdf';

                    pdf.create(html, options).toFile(fullPath, (err, res) => {
                        if (err) return console.error(err);
                        console.log(res);

                        completed++;
                        if (completed == files.length) cb();
                    });
                }
            }
        });
    }

    function customSort(a, b) {
        return a.localeCompare(b);
    }

    function combine(cb) {
        console.log('Combining PDFs...');
        find.file(/\.md$/, __dirname + '/docs', (files) => {
            if (files.length == 0) {
                cb();
            } else {

                files.sort(customSort);

                for (var i = 0; i < files.length; i++) {

                    files[i] = './tmp' + path.dirname(files[i]).replace(__dirname + '/docs', '').replace(/\/(\d+)?_([\w\d-])/g, '/$2') + '/' + path.basename(files[i], '.md').replace(/^(\d+)?_(.+)$/, '$2') + '.pdf';

                    console.log('pdf: ' + files[i]);
                }

                if (!fs.existsSync('./static/pdf')) fs.mkdirSync('./static/pdf');
                merge(files, { output: './static/pdf/' + docs.title + '.pdf' }).then(() => { cb(); });
            }
        });
    }

    function addLink(cb) {
        console.log('Adding link to PDFs...');
        find.file(/\.html$/, __dirname + '/static', (files) => {
            if (files.length == 0) {
                cb();
            } else {

                let completed = 0;

                for (var i = 0; i < files.length; i++) {
                    let file = files[i];

                    var rel = path.relative(file, __dirname + '/static/pdf').substring(3) + '/' + docs.title + '.pdf';

                    let options = {
                        patterns: [
                            {
                                match: /\[pdf_link\]/g,
                                replacement: rel
                            }
                        ]
                    }

                    let replacer = new Replacer(options);
                    let contents = fs.readFileSync(file).toString();
                    let result = replacer.replace(contents);

                    if (result) {
                        fs.truncate(file, 0, () => {
                            fs.writeFile(file, result, (error) => {

                                if (error) {
                                    console.error(error);
                                    process.exit(1);
                                }

                                completed++;
                                if (completed == files.length) cb();
                            });
                        });
                    } else {
                        completed++;
                    }

                    if (completed == files.length) cb();
                }
            }
        });


    }
}

module.exports = pdfBuilder;