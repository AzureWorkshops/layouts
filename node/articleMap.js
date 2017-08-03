let fs = require('fs'),
    find = require('find'),
    Replacer = require('pattern-replace');


function articleMap() {

    this.build = function () {
        let matches = [];

        let h4Options = {
            patterns: [
                {
                    match: /<h2\sid="([\w-\s]*)">([\w-\s]*)<\/h2>/g,
                    replacement: function (match, id, title) {
                        matches.push({ id: id, title: title });
                        return match;
                    }
                }
            ]
        }

        find.eachfile(/\.html$/, __dirname + '/static', (file) => {
            matches = [];

            let replacer = new Replacer(h4Options);
            let contents = fs.readFileSync(file).toString();

            // Get H2's
            replacer.replace(contents);

            let links = '';

            if (matches.length > 0) {
                links += "<strong>In this article</strong>";
                links += "<ol>";
                matches.forEach((match) => {
                    links += `<li><a href="#${match.id}">${match.title}</a></li>`;
                });
                links += "</ol>";
            }

            let linksOptions = {
                patterns: [
                    {
                        match: /\[article_map\]/g,
                        replacement: links
                    }
                ]
            }
            replacer = new Replacer(linksOptions);
            let result = replacer.replace(contents);

            if (result) {
                fs.truncate(file, 0, () => {
                    fs.writeFile(file, result, (error) => {

                        if (error) {
                            console.error(error);
                            process.exit(1);
                        }
                    });
                });
            }
        });
    }
}

module.exports = articleMap;