/**
 *
 * En caso de necesitar tomar argumentos
 * var pass = process.argv[2];
 *
 */

var lightwallet = require("./wallet/lightwallet.js");

function generateRandomSeed() {
    var seed = lightwallet.keystore.generateRandomSeed();
    console.log(seed);
}

generateRandomSeed();