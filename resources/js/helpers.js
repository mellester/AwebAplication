export function notifyMe (message, titol = 'TITLE', icon = icon) {
    if (!('Notification' in window)) {
      console.error('This browser does not support desktop notification')
    } else if (Notification.permission === 'granted') {
      let notification = new Notification(titol, {
        icon: icon,
        body: message,
        vibrate: [100, 50, 100],
        data: {
          dateOfArrival: Date.now(), 
          primaryKey: 1
        }
      })
    }
} 