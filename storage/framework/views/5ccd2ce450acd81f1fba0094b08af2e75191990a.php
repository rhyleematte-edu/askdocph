<?php $__env->startSection('title', 'Dashboard - AskDocPH'); ?>

<?php $__env->startSection('content'); ?>
<?php
  $user      = Auth::user();
  $avatarUrl = $user->avatar_url;
  $fullName  = $user->full_name ?: ($user->name ?? 'User');
  $shortName = $user->short_name ?: $fullName;
  $username  = $user->username ?? 'username';
?>


<script>
window.DASH_ROUTES = {
  feed:          "<?php echo e(route('dashboard.feed')); ?>",
  storePost:     "<?php echo e(route('profile.posts.store')); ?>",
  toggleLike:    function(id){ return "/profile/posts/" + id + "/like"; },
  toggleSave:    function(id){ return "/profile/posts/" + id + "/save"; },
  storeComment:  function(id){ return "/profile/posts/" + id + "/comments"; },
  destroyComment:function(id){ return "/profile/comments/" + id; },
  destroyPost:   function(id){ return "/profile/posts/" + id; },
  updatePost:    function(id){ return "/profile/posts/" + id; },
};
window.MY_PROFILE_URL = "<?php echo e(route('profile.show', Auth::id())); ?>";
</script>

<main class="dash">

  
  <div class="dash-body">

    
    <?php echo $__env->make('partials.sidebar', ['active' => 'feed'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if(Auth::user()->isApprovedDoctor()): ?>
    <?php endif; ?>

    
    <section class="dash-main">

      
      <div class="panel composer" id="composerPanel">
        <div class="composer-top">
          <div class="avatar sm">
            <img src="<?php echo e($avatarUrl); ?>" alt="You" />
          </div>
          <textarea id="dashPostText" placeholder="Share your thoughts, feelings, or progress..."></textarea>
        </div>

        
        <div id="dashMediaPreviewArea" class="media-preview-grid" style="display:none;"></div>

        
        <div class="hashtag-row" id="dashHashtagRow" style="display:none;">
          <i data-lucide="hash"></i>
          <input type="text" id="dashHashtagInput" placeholder="anxiety, hope, recovery  (comma-separated)" />
        </div>


        
        <div class="mood-bar" id="dashMoodBar" style="display:none;">
          <span class="mood-label">How are you feeling?</span>
          <div class="mood-options">
            <button class="mood-btn" type="button" data-mood="😊 Happy">😊 Happy</button>
            <button class="mood-btn" type="button" data-mood="😔 Sad">😔 Sad</button>
            <button class="mood-btn" type="button" data-mood="😰 Anxious">😰 Anxious</button>
            <button class="mood-btn" type="button" data-mood="😤 Stressed">😤 Stressed</button>
            <button class="mood-btn" type="button" data-mood="🥰 Grateful">🥰 Grateful</button>
            <button class="mood-btn" type="button" data-mood="😴 Tired">😴 Tired</button>
            <button class="mood-btn" type="button" data-mood="💪 Motivated">💪 Motivated</button>
            <button class="mood-btn" type="button" data-mood="😌 Calm">😌 Calm</button>
          </div>
          <div id="dashSelectedMoodDisplay" class="selected-mood" style="display:none;"></div>
        </div>

        <div class="composer-bottom">
          
          <label class="chip-btn" for="mediaUpload" title="Attach photo/video" style="cursor:pointer;">
            <i data-lucide="image"></i> Photo
          </label>
          <input type="file" id="mediaUpload" accept="image/*,video/*" multiple style="display:none;" />

          
          <button class="chip-btn" type="button" id="dashMoodToggleBtn" title="Add mood">
            <i data-lucide="smile"></i> Mood
          </button>

          
          <button class="chip-btn" type="button" id="dashHashtagToggleBtn" title="Add hashtags">
            <i data-lucide="hash"></i> Tags
          </button>

          
          <div class="link-popup-wrap" id="dashLinkWrap">
            <button class="chip-btn" type="button" id="dashLinkToggleBtn" title="Add link">
              <i data-lucide="link"></i> Link
            </button>
            <div class="link-popup-card" id="dashLinkRow" onclick="event.stopPropagation()">
              <div class="link-popup-inputs">
                <div class="link-popup-row">
                  <i data-lucide="type" class="link-popup-icon" style="width:16px;height:16px;"></i>
                  <input type="text" id="dashLinkNameInput" placeholder="Text">
                </div>
                <div class="link-popup-row">
                  <i data-lucide="link" class="link-popup-icon" style="width:16px;height:16px;"></i>
                  <input type="url" id="dashLinkUrlInput" placeholder="Type or paste a link" onkeydown="if(event.key==='Enter'){document.getElementById('dashApplyLinkBtn').click();event.preventDefault();}">
                </div>
              </div>
              <button type="button" class="link-popup-apply" id="dashApplyLinkBtn">Apply</button>
            </div>
          </div>

          <div id="composerFeedback" class="composer-feedback"></div>

          <button class="share-btn" type="button" id="dashShareBtn">
            Share <i data-lucide="send"></i>
          </button>
        </div>
      </div>

      
      <div id="dashFeed">
        <div class="feed-loading panel" id="feedLoading">
          <i data-lucide="loader"></i>
          <span>Loading posts…</span>
        </div>
      </div>

      <div id="feedEmpty" class="empty-state panel" style="display:none;">
        <i data-lucide="file-text"></i>
        <p>No posts yet. Be the first to share something!</p>
      </div>

    </section>
  </div>
</main>


<div id="dash-toast" class="dash-toast" aria-live="polite"></div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\websystem\resources\views/userdashboard.blade.php ENDPATH**/ ?>