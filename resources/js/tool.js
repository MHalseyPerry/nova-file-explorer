Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'file-explorer',
      path: '/file-explorer',
      component: require('./components/Tool'),
    },
  ])
})
