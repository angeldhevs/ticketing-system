module.exports = {
  channels: {
    user: Echo.private('App.User.' + __App.User.id),
    ticket: Echo.channel('Ticket')
  },
  events: {
    ticket: {
      created: '.Ticket.Created',
      updated: '.Ticket.Updated',
    }
  }
};