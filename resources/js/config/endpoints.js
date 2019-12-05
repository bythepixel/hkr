export const getHackathonsEndpoint = () => `/api/hackathon`,
    newHackathonEndpoint = () => `/api/hackathon`,
    getHackathonEndpoint = (id, order, direction) => `/api/hackathon/${id}/${order}/${direction}`,

    newIdeaEndpoint = () => `/api/idea`,
    addIdeaVoteEndpoint = () => `/api/ideaVote`,
    deleteIdeaVoteEndpoint = (voteId) => `/api/ideaVote/${voteId}`,
    addIdeaMessageEndpoint = (id) => `/api/idea/${id}/message`,
    addIdeaChildMessageEndpoint = (id, messageId) => `/api/idea/${id}/message/${messageId}`,

    getIdeaVotesEndpoint= (id) => `/api/idea/${id}/votes`,

    newFeatureEndpoint = () => `/api/feature`,
    addFeatureVoteEndpoint = (id) => `/api/feature/${id}/vote`,
    deleteFeatureVoteEndpoint = (id, voteId) => `/api/feature/${id}/vote/${voteId}`,
    addFeatureMessageEndpoint = (id) => `/api/feature/${id}/message`,
    addFeatureChildMessageEndpoint = (id, messageId) => `/api/feature/${id}/message/${messageId}`,

    loginEndpoint = () => `/api/login`;
