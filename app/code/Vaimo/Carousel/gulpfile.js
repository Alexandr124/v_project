/*
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

var gulp = require('gulp'),
    babel = require('gulp-babel'),
    plumber = require('gulp-plumber'),
    del = require('del');

var localReactPath = 'sources/',
    localReactDestPath = 'view/frontend/web/js/';

/*
Functions for pretty log messages
========================================================================== */

function printPrettyErrorMessages(message, type, additionalMessage) {
    printPrettyMessageDividers("error");
    console.log("\x1b[31m\x1b[1m", "Error detected with " + type + ":", "\x1b[22m\x1b[0m");
    console.log("\x1b[41m\x1b[37m", message, "\x1b[0m\x1b[0m");
    if (additionalMessage) console.log("\x1b[32m", additionalMessage, "\x1b[0m");
    printPrettyMessageDividers("error");
}

function printPrettyResourceCompilationMessages(type) {
    printPrettyMessageDividers("normal");
    console.log("=> Running compilation of \x1b[36m" + type + "\x1b[0m:");
    printPrettyMessageDividers("normal");
}

function printPrettyTaskCompilationMessages(type, from) {
    console.log("=> Running compilation of \x1b[36m" + type + " files\x1b[0m from inside \x1b[36m" + from + "\x1b[0m");
}

function printPrettyWatchMessages(type, from) {
    console.log(" Watching \x1b[36m" + type + "\x1b[0m files for \x1b[36m\x1b[1m" + themeName + "\x1b[0m\x1b[0m from: \x1b[32m" + from + "\x1b[0m");
}

function printPrettyMessageDividers(type) {
    if (type == "error") {
        console.log("\x1b[31m", "==============================================================================", "\x1b[0m");
    } else {
        console.log("\x1b[32m", "=======================================", "\x1b[0m");
    }
}


/*
 'clean-react'
 ======================== */

gulp.task('clean-react', function () {
    console.log('=> Removing React destination folder');
    return del(localReactDestPath + '**', {
        force: true
    });
});

/*
 'react-local'
 ======================== */

gulp.task('react', ['clean-react'], function () {
    printPrettyTaskCompilationMessages('Local React JavaScript', localReactPath);
    return gulp.src(localReactPath + "**/*.+(js|jsx)")
        .pipe(plumber(function (error) {
            printPrettyErrorMessages(error.message, 'Local React');
            this.emit('end');
        }))
        .pipe(babel())
        .pipe(gulp.dest(localReactDestPath));

});
