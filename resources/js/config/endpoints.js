export const getHackathonsEndpoint = () => `/api/hackathon`,
    newHackathonEndpoint = () => `/api/hackathon`,
    getHackathonEndpoint = (id, order, direction, showArchives) => `/api/hackathon/${id}/${order}/${direction}/${showArchives}`,
    resetHackathonEndpoint = (id) => `/api/hackathon/reset/${id}`,
    deleteHackathonEndpoint = (id) => `/api/hackathon/delete/${id}`,

    newIdeaEndpoint = () => `/api/idea`,
    deleteIdeaEndpoint = (id) => `/api/idea/${id}/delete`,
    archiveIdeaEndpoint = (id) => `/api/idea/${id}/archive`,
    restoreIdeaEndpoint = (id) => `/api/idea/${id}/restore`,
    addIdeaVoteEndpoint = () => `/api/ideaVote`,
    addIdeaFavoriteEndpoint = () => `/api/ideaFavorite`,
    deleteIdeaVoteEndpoint = (ideaId) => `/api/ideaVote/deleteByUserAndIdea/${ideaId}`,
    addIdeaMessageEndpoint = () => `/api/ideaMessage`,
    addIdeaChildMessageEndpoint = (id, messageId) => `/api/idea/${id}/message/${messageId}`,

    getIdeaVotesEndpoint= (id) => `/api/idea/${id}/votes`,
    getIdeaEndpoint = (id) => `/api/idea/${id}`,

    loginEndpoint = () => `/api/login`,
    logoutEndpoint = () => `/api/logout`;
