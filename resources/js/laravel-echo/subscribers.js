window.Echo.private('drivers')
    .listen('.SosEvent', (e) => {
        console.log(e);
    })
    .listen('.DriverTakeOrderEvent', (e) => {
        console.log(e);
    })
    .listen('.DriverChatMessageEvent', (e) => {
        console.log(e);
    });