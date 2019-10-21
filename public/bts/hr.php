<?php

  require_once '../../private/access/control.php';

?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="parkjongwon.com" />
    <title>Behind The Scroll - DA Student Newspaper</title>
    <!-- <link rel="canonical" href="https://thescroll.com/" /> -->
    <link rel="stylesheet" href="../lib/style/dist/normalize.min.css" />
    <link rel="stylesheet" href="../lib/style/dist/universal.min.css<?php echo "?v=".filemtime("../lib/style/dist/universal.min.css"); ?>" />
    <link rel="stylesheet" href="../lib/style/dist/bts/hr.min.css<?php echo "?v=".filemtime("../lib/style/dist/bts/hr.min.css"); ?>" />
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,500,700|Open+Sans:300,400,700,800&display=swap" rel="stylesheet">
    <noscript>
      You need to enable JavaScript to run this app.
    </noscript>
  </head>

  <body style="max-width:1000px;margin:0 auto;padding:20px;">

    <h1>Human Resources</h1>

    <h2>Manage Roles</h2>

    <h3>Add Role</h3>
    <div id="role-form">
      <input id="role-name" type="text" placeholder="Role name" value="Test Role" />
      <label for="role-cb1">
        <input id="role-cb1" type="checkbox" name="is_super" />
        <span>is_super</span>
      </label>
      <label for="role-cb2">
        <input id="role-cb2" type="checkbox" name="article_access" />
        <span>article_access</span>
      </label>
      <label for="role-cb3">
        <input id="role-cb3" type="checkbox" name="article_access_nonself" />
        <span>article_access_nonself</span>
      </label>
      <label for="role-cb4">
        <input id="role-cb4" type="checkbox" name="article_delete" />
        <span>article_delete</span>
      </label>
      <label for="role-cb5">
        <input id="role-cb5" type="checkbox" name="article_delete_nonself" />
        <span>article_delete_nonself</span>
      </label>
      <label for="role-cb6">
        <input id="role-cb6" type="checkbox" name="article_status" />
        <span>article_status</span>
      </label>
      <label for="role-cb7">
        <input id="role-cb7" type="checkbox" name="stat_access" />
        <span>stat_access</span>
      </label>
      <label for="role-cb8">
        <input id="role-cb8" type="checkbox" name="stat_access_nonself" />
        <span>stat_access_nonself</span>
      </label>
      <label for="role-cb9">
        <input id="role-cb9" type="checkbox" name="role_access" />
        <span>role_access</span>
      </label>
      <label for="role-cb10">
        <input id="role-cb10" type="checkbox" name="role_status" />
        <span>role_status</span>
      </label>
      <label for="role-cb11">
        <input id="role-cb11" type="checkbox" name="hr_access" />
        <span>hr_access</span>
      </label>
      <label for="role-cb12">
        <input id="role-cb12" type="checkbox" name="hr_super" />
        <span>hr_super</span>
      </label>
      <label for="role-cb13">
        <input id="role-cb13" type="checkbox" name="setting_access" />
        <span>setting_access</span>
      </label>
      <label for="role-cb14">
        <input id="role-cb14" type="checkbox" name="setting_access_nonself" />
        <span>setting_access_nonself</span>
      </label>
      <div id="role-add-btn" style="cursor:pointer;">Add</div>
    </div>

    <h2>Manage Users</h2>

    <h3>Add User</h3>
    <div id="user-add-form">
      <input id="user-add-email" type="text" placeholder="User Email (e.g. jsmith20)" value="test<?php echo rand(10, 99999); ?>" />
      <input id="user-add-name-f" type="text" placeholder="First name" value="John" />
      <input id="user-add-name-l" type="text" placeholder="Last name" value="Smith" />
      <input id="user-add-name-m" type="text" placeholder="M.I." />
      <input id="user-add-name-d" type="text" placeholder="Display name" value="John Smith 21" />
      <select id="user-add-role">
        <option value="1">Admin</option>
      </select>
      <div id="user-add-btn" style="cursor:pointer;">Add</div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
    // https://github.com/axios/axios/issues/1322
    // https://fetch.spec.whatwg.org/#cors-safelisted-request-header
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.get('../actions/hr.php?req=data')
      .then(res => {
        const {status, payload} = res.data;
        if (status === 'unauthorized'){}
        else {
          console.log(payload.roles);
          console.log(payload.users);
        }
      })
      .catch(err => {
        console.error(err);
      });

    (function($){
      //
      // Role: Add
      //
      $('#role-add-btn').on('click', function(){
        const
          name = $('#role-name').val().trim(),
          $labels = $('#role-form').children('label'),
          jobs = {};
        $labels.map((key, label) => {
          const $cb = $(label).children('input');
          jobs[$cb.attr('name')] = $cb.is(':checked');
        });

        if (name.length < 3) return;

        const postData = {req: 'add_role', name, jobs};
        console.log(postData);

        axios.post('../actions/hr.php', postData)
          .then(res => {
            console.log(res);
          })
          .catch(err => {
            console.error(err);
          });
      });
      //
      // User: Add
      //
      $('#user-add-btn').on('click', function(){
        const
          name = {
            first: $('#user-add-name-f').val().trim(),
            middle: $('#user-add-name-m').val().trim(),
            last: $('#user-add-name-l').val().trim(),
            display: $('#user-add-name-d').val().trim(),
          },
          email = $('#user-add-email').val().trim(),
          role = $('#user-add-role').val();

        console.log(name, email, role);
        if (name.first.length < 3 || name.last.length < 2) return;

        const postData = {req: 'add_user', name, email, role};
        console.log(postData);

        axios.post('../actions/hr.php', postData)
          .then(res => {
            console.log(res);
          })
          .catch(err => {
            console.error(err);
          });
      });
    })(jQuery);
    </script>
  </body>
</html>
