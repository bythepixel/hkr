export const getHackathonsEndpoint = () => `/api/hackathon`,
    newHackathonEndpoint = () => `/api/hackathon`,
    getHackathonEndpoint = (id, order, direction) => `/api/hackathon/${id}/${order}/${direction}`,
    resetHackathonEndpoint = (id) => `/api/hackathon/reset/${id}`,

    newIdeaEndpoint = () => `/api/idea`,
    deleteIdeaEndpoint = (id) => `/api/idea/${id}/delete`,
    addIdeaVoteEndpoint = () => `/api/ideaVote`,
    deleteIdeaVoteEndpoint = (ideaId) => `/api/ideaVote/deleteByUserAndIdea/${ideaId}`,
    addIdeaMessageEndpoint = (id) => `/api/idea/${id}/message`,
    addIdeaChildMessageEndpoint = (id, messageId) => `/api/idea/${id}/message/${messageId}`,

    getIdeaVotesEndpoint= (id) => `/api/idea/${id}/votes`,
    getIdeaEndpoint = (id) => `/api/idea/${id}`,

    loginEndpoint = () => `/api/login`,
    logoutEndpoint = () => `/api/logout`;
