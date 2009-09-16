/**
 * This script is part of the XP framework
 *
 * $Id$+
 *
 * Get data from stdin and pass it to
 * the JSLINT object
 *
 */
(function (a) {
    var line, input, blcount;

    input = '';
    while (true) {
        line = readline();
        input = input + line + "\n";

        // HACK
        // cant figure out how to tell EOF
        // from a normal blank line so arbitrarily
        // count 100 sequential blank lines and
        // assume we have finished
        if (line.length === 0) {
            // blank line, so increment
            blcount = blcount + 1;
            if (blcount >= 100) {
              break;
            }
        } else {
            // not blank, so reset
            blcount = 0;
        }
    }

    if (!input) {
        print("jslint: Couldn't open file '" + a[0] + "'.");
        quit(1);
    }
    if (!JSLINT(input, {bitwise: true, eqeqeq: true, immed: true,
            newcap: true, nomen: true, onevar: true, plusplus: true,
            regexp: true, rhino: true, undef: true, white: true,
            indentby: 2, laxbreak: true, passfail: true})) {
        for (i = 0; i < JSLINT.errors.length; i += 1) {
            e = JSLINT.errors[i];
            if (e) {
                print('Lint at line ' + e.line + ' character ' +
                        e.character + ': ' + e.reason);
                print((e.evidence || '').
                        replace(/^\s*(\S*(\s+\S+)*)\s*$/, "$1"));
                print('');
            }
        }
        quit(2);
    }
}(arguments));
