import store from './store';

export const digestNewVotes = (ideas, ideaId, newVotes) => {
    for (let j = 0; j < ideas.length; j++) {
        if (ideas[j].id !== ideaId) {
            continue;
        }
        store.hackathon.ideas[j].votes = newVotes;
    }
};

export const digestNewFavorites = (ideas, ideaId, newFavorites) => {
  for (let j = 0; j < ideas.length; j++) {
    if (ideas[j].id !== ideaId) {
      continue;
    }
    store.hackathon.ideas[j].favorites = newFavorites;
  }
};
