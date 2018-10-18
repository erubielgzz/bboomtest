export const eventBus = new Vue();

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

Vue.filter('date_to_human_short', function (value) {
    return moment(value).format("D/MMM/YYYY");
});

Vue.filter('hour_to_human', function (value) {
    return moment(value).format("hh:mm a");
});

Vue.filter('highlight', function(str, q){
    if( !str ) return "";
    if( !q ) return str;

    var str_folded = accent_fold(str).toLowerCase().replace(/[<>]+/g, '');
    var q_folded = accent_fold(q).toLowerCase().replace(/[<>]+/g, '');  // Create an intermediate string with hilite hints
    // Example: fulani<lo> <lo>pez
    var re = new RegExp(q_folded, 'g');
    var hilite_hints = str_folded.replace(re,'<'+q_folded+'>');  // Index pointer for the original string
    var spos = 0;
    // Accumulator for our final string
    var highlighted = '';  // Walk down the original string and the hilite hint
    // string in parallel. When you encounter a < or > hint,
    // append the opening / closing tag in our final string.
    // If the current char is not a hint, append the equiv.
    // char from the original string to our final string and
    // advance the original string's pointer.
    for (var i = 0; i< hilite_hints.length; i++) {
      var c = str.charAt(spos);
      var h = hilite_hints.charAt(i);
      if (h === '<') {
        highlighted += '<span style="background-color:yellow;">';
      } else if (h === '>') {
        highlighted += '</span>';
      } else {
        spos += 1;
        highlighted += c;
      }
    }
    return highlighted;
});

import App from './views/App'
import Welcome from './views/Welcome'
import Images from './views/Images'
import Notes from './views/Notes'
import PageNotFound from './views/PageNotFound'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'welcome',
            component: Welcome
        },
        {
            path: '/images/',
            name: 'images',
            component: Images,
            children: [
                {
                    name: 'image',
                    path: ':image_id',
                },
            ]
        },
        {
            path: '/notes/',
            name: 'notes',
            component: Notes,
            children: [
                {
                    name: 'note',
                    path: ':note_id',
                },
            ]
        },
        {
            name: 'not-found',
            path: "/404",
            component: PageNotFound
        },
        {
            path: "*",
            redirect: { name: 'not-found' }
        }
    ],
});

const app = new Vue({
    el: '#app',
    render: h => h(App),
    router,
});
