import { defineComponent } from 'vue';

export default defineComponent({
    props: ['movie'],
    template: `
        <div class="card">
            <div class="row no-gutters">
                <div class="col-4">
                    <img :src="'https://image.tmdb.org/t/p/w500' + movie.poster_path" class="card-img" :alt="movie.title">
                </div>
                <div class="col-8">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ movie.title }}
                        </h5>
                        <p class="card-text">
                            {{ movie.overview }}
                        </p>
                        <p class="card-text">
                            <small class="text-muted">
                                Voir la fiche
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    `
});