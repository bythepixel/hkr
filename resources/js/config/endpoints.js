export const getHackathonsEndpoint = () => `/api/hackathon`,
    newHackathonEndpoint = () => `/api/hackathon`,
    getHackathonEndpoint = (id, sort, filter) => `/api/hackathon/${id}/${sort}/${filter}`,
    resetHackathonEndpoint = (id) => `/api/hackathon/reset/${id}`,
    deleteHackathonEndpoint = (id) => `/api/hackathon/delete/${id}`,
    lockHackathonEndpoint = (id) => `/api/hackathon/lock/${id}`,
    unlockHackathonEndpoint = (id) => `/api/hackathon/unlock/${id}`,

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

    getUserEndpoint = () => `/api/user`,
    copyIdeaEndpoint = () => `/api/user/copy-idea`,

    loginEndpoint = () => `/api/login`,
    logoutEndpoint = () => `/api/logout`;
