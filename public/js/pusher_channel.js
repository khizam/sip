Echo
    .channel('channel-name')
    .listen('Testing', e => {
        console.log(e.data)
    })
