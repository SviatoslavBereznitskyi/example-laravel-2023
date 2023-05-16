/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { Centrifuge } from 'centrifuge';
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');

let userId = "ea9a0414-03d9-47a9-99ea-09e4cb586252";

// helper functions to work with escaping html.
const tagsToReplace = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;'
};

function replaceTag(tag) {
    return tagsToReplace[tag] || tag;
}

function safeTagsReplace(str) {
    return str.replace(/[&<>]/g, replaceTag);
}

window.addEventListener('load', () => {
    initApp();
})

function initApp() {
    const centrifuge = new Centrifuge("ws://" + window.location.host + "/connection/websocket");

    centrifuge.on('connect', function(ctx) {
        console.log("connected", ctx);
    });

    centrifuge.on('disconnect', function(ctx) {
        console.log("disconnected", ctx);
    });

    centrifuge.on('publish', function(ctx) {
        if (ctx.data.roomId.toString() === currentRoomId) {
            addMessage(ctx.data);
            scrollToLastMessage();
        }
        addRoomLastMessage(ctx.data);
    });

    centrifuge.connect();
}
