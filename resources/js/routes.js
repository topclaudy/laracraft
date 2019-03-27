export default [
    {path: '/', redirect: '/themes'},

    {
        path: '/themes',
        name: 'themes',
        component: require('./screens/themes/index').default
    },

    {
        path: '/themes/:id',
        name: 'theme',
        component: require('./screens/themes/configure').default,
        props: true
    },

    {
        path: '/blocks',
        name: 'blocks',
        component: require('./screens/blocks/index').default
    },

    {
        path: '/blocks/edit/:id?',
        name: 'block-edit',
        component: require('./screens/blocks/editor').default,
        props: true
    },

    {
        path: '/blocks/:id',
        name: 'block',
        component: require('./screens/blocks/show').default
    },

    {
        path: '/components',
        name: 'components',
        component: require('./screens/components/index').default
    },
];
