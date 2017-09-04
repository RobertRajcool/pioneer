/**
 * Created by robert on 29/9/16.
 */


(function(global) {
    var angular2ModalVer = '@2.0.2';
    var plugin = 'bootstrap';
    var paths= {
        // paths serve as alias
        'npm:': 'node_modules/'
    }
    var map = {
        // our app is within the app folder
        app: 'app',

        // angular bundles
        '@angular/core': 'npm:@angular/core/bundles/core.umd.js',
        '@angular/common': 'npm:@angular/common/bundles/common.umd.js',
        '@angular/compiler': 'npm:@angular/compiler/bundles/compiler.umd.js',
        '@angular/platform-browser': 'npm:@angular/platform-browser/bundles/platform-browser.umd.js',
        '@angular/platform-browser-dynamic': 'npm:@angular/platform-browser-dynamic/bundles/platform-browser-dynamic.umd.js',
        '@angular/http': 'npm:@angular/http/bundles/http.umd.js',
        '@angular/router': 'npm:@angular/router/bundles/router.umd.js',
        '@angular/forms': 'npm:@angular/forms/bundles/forms.umd.js',
        // other libraries
        'rxjs':                      'npm:rxjs',
        'angular-in-memory-web-api': 'npm:angular-in-memory-web-api',
        "angular2-jwt": 'node_modules/angular2-jwt',
        'ng2-spin-kit':'node_modules/ng2-spin-kit/',
        'ng2-bs3-modal': 'node_modules/ng2-bs3-modal',
        'ng2-datetime-picker':'node_modules/ng2-datetime-picker/dist',
        'angular2-highcharts': 'npm:angular2-highcharts',
        'highcharts': 'npm:highcharts',
        'highcharts-3d':'npm:highcharts',
        'jspdf' : 'node_modules/jspdf/dist/jspdf.min.js',



    };
    var packages = {
        app: {
            main: './main.js',
            defaultExtension: 'js'
        },
        'angular2-jwt':
        {
            main:'./angular2-jwt.js',
            defaultExtension: 'js'
        },
        rxjs: {
            defaultExtension: 'js'
        },
        'angular-in-memory-web-api': {
            main: './index.js',
            defaultExtension: 'js'
        },
        'ng2-bs3-modal':{
            main: 'ng2-bs3-modal.js',
            defaultExtension: 'js'
        },
        'ng2-datetime-picker':{
            main: 'ng2-datetime-picker.umd.js',
            defaultExtension: 'js'
        },
        'angular2-highcharts': {
            main: './index.js',
            defaultExtension: 'js'
        },
        'highcharts': {
            main: './highstock.src.js',

            defaultExtension: 'js'
        },
        'highcharts-3d':{
            main: './highcharts-3d.src.js',

            defaultExtension: 'js'
        },

    };
    //System config Here
    System.config({
        paths:paths,
        map: map,
        packages: packages
    });
    //System Imports Here
    global.bootstrapping = System
        .import( "app" )
        .then(
            function handleResolve() {

                console.info( "System.js successfully bootstrapped app." );

            },
            function handleReject( error ) {

                console.warn( "System.js could not bootstrap the app." );
                console.error( error );

                return( Promise.reject( error ) );

            }
        );
})(window);
