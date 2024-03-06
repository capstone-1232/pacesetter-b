<?php 
/** 
 * @package pacesetter
 * 
 * 
 * 
 * */ 
get_header()
?>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    
    <h1> Pacesetter Blog</h1>
    
    <p>Welcome to the Pacesetter Blog</p>
<div id="filtered_posts">
    <span class="filter_button" v-on:click="isHidden = !isHidden">Filter by Category</span>
    <div class="filters" v-if="!isHidden">
        <span class="filter" :class="{ active: currentFilter === '' }" v-on:click="setFilter('')">All</span>
        <span class="filter" :class="{ active: currentFilter === category.id }" v-on:click="setFilter(category.id)" v-for="category in categories">{{ category.name }}</span>
    </div>

    <transition-group id="home" class="categories" name="categories" >
        <div v-if="currentFilter === post.categories['0'] || currentFilter === ''" v-bind:key="post.title.rendered" v-for="post in posts">
            <a v-bind:href="post.link"><img v-bind:src="post._embedded['wp:featuredmedia']['0'].media_details.sizes.medium_large.source_url"></a>
            <a v-bind:href="post.link"><h4 v-html="post.name"></h4></a>
            <p class="smaller" v-html="post.title.rendered"></p>
    </div>
    </transition-group>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/js/filter.js"></script>


<?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        //this is the content being looped
?>
<!-- close php and start html-->
<article class="flex">
<?php echo get_the_post_thumbnail($post->ID, 'blog','large');?>
<div>

    <h3><?php the_title();?></h3>
    <p><?php the_date() ?></p>
    <p><?php the_excerpt();?></p>
</div>
</article>
<?php
    endwhile;
endif;
?>