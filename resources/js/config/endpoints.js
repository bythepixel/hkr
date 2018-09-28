export const getHackathonsEndpoint = () => `/api/hackathon`,
    newHackathonEndpoint = () => `/api/hackathon`,
    getHackathonEndpoint = (id) => `/api/hackathon/${id}`,

    newIdeaEndpoint = () => `/api/idea`,
    addIdeaVoteEndpoint = (id) => `/api/idea/${id}/vote`,
    deleteIdeaVoteEndpoint = (id, voteId) => `/api/idea/${id}/vote/${voteId}`,
    addIdeaMessageEndpoint = (id) => `/api/idea/${id}/message`,
    addIdeaChildMessageEndpoint = (id, messageId) => `/api/idea/${id}/message/${messageId}`,

    newFeatureEndpoint = () => `/api/feature`,
    addFeatureVoteEndpoint = (id) => `/api/feature/${id}/vote`,
    deleteFeatureVoteEndpoint = (id, voteId) => `/api/feature/${id}/vote/${voteId}`,
    addFeatureMessageEndpoint = (id) => `/api/feature/${id}/message`,
    addFeatureChildMessageEndpoint = (id, messageId) => `/api/feature/${id}/message/${messageId}`,

    loginEndpoint = () => `/api/login`;