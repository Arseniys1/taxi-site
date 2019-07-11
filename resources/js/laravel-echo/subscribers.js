window.Echo.private('drivers')
    .listen('.SosEvent', (e) => {
        console.log(e);
    });