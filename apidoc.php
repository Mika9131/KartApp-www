	<?php

// HEADER einbinden
include("header.php");

?>
	<div class="container">
		<h1 id="buckets">API Dokumentation</h1>
		<ul id="markdown-toc">
  <li><a href="#userapi">User</a></li>
  <li><a href="#cardsetapi">Cardset</a></li>
  <li><a href="#cardsapi">Cards</a></li>
  <li><a href="#statsapi">Stats</a></li>
  <li><a href="#friendlistapi">Friendlist</a></li>
</ul>

		<h2 id="userapi">User</h2>

<pre><code>GET /user
</code></pre>

<h3 id="response">Response</h3>

<pre class="headers"><code>Status: 200 OK
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59</code></pre>

<pre><code class="language-javascript"><span class="p">{</span>
<span class="s2">"id"</span> <span class="o">:</span> <span class="mi">2754</span><span class="p">,</span>
<span class="s2">"name"</span> <span class="o">:</span> <span class="s2">"Great Marks"</span><span class="p">,</span>
<span class="s2">"description"</span> <span class="o">:</span> <span class="s2">"Collecting superb brand marks from the &lt;a href=\"https://dribbble.com\"&gt;Dribbbleverse&lt;/a&gt;."</span><span class="p">,</span>
<span class="s2">"shots_count"</span> <span class="o">:</span> <span class="mi">251</span><span class="p">,</span>
<span class="s2">"created_at"</span> <span class="o">:</span> <span class="s2">"2011-05-20T21:05:55Z"</span><span class="p">,</span>
<span class="s2">"updated_at"</span> <span class="o">:</span> <span class="s2">"2014-02-21T16:37:12Z"</span><span class="p">,</span>
<span class="s2">"user"</span> <span class="o">:</span> <span class="p">{</span>
	<span class="s2">"id"</span> <span class="o">:</span> <span class="mi">1</span><span class="p">,</span>
	<span class="s2">"name"</span> <span class="o">:</span> <span class="s2">"Dan Cederholm"</span><span class="p">,</span>
	<span class="s2">"username"</span> <span class="o">:</span> <span class="s2">"simplebits"</span><span class="p">,</span>
	<span class="s2">"html_url"</span> <span class="o">:</span> <span class="s2">"https://dribbble.com/simplebits"</span><span class="p">,</span>
	<span class="s2">"avatar_url"</span> <span class="o">:</span> <span class="s2">"https://d13yacurqjgara.cloudfront.net/users/1/avatars/normal/dc.jpg?1371679243"</span><span class="p">,</span>
	<span class="s2">"bio"</span> <span class="o">:</span> <span class="s2">"Co-founder &amp;amp; designer of &lt;a href=\"https://dribbble.com/dribbble\"&gt;@Dribbble&lt;/a&gt;. Principal of SimpleBits. Aspiring clawhammer banjoist."</span><span class="p">,</span>
	<span class="s2">"location"</span> <span class="o">:</span> <span class="s2">"Salem, MA"</span><span class="p">,</span>
	<span class="s2">"links"</span> <span class="o">:</span> <span class="p">{</span>
		<span class="s2">"web"</span> <span class="o">:</span> <span class="s2">"http://simplebits.com"</span><span class="p">,</span>
		<span class="s2">"twitter"</span> <span class="o">:</span> <span class="s2">"https://twitter.com/simplebits"</span>
	<span class="p">},</span>
	<span class="s2">"buckets_count"</span> <span class="o">:</span> <span class="mi">10</span><span class="p">,</span>
	<span class="s2">"comments_received_count"</span> <span class="o">:</span> <span class="mi">3395</span><span class="p">,</span>
	<span class="s2">"followers_count"</span> <span class="o">:</span> <span class="mi">29262</span><span class="p">,</span>
	<span class="s2">"followings_count"</span> <span class="o">:</span> <span class="mi">1728</span><span class="p">,</span>
	<span class="s2">"likes_count"</span> <span class="o">:</span> <span class="mi">34954</span><span class="p">,</span>
	<span class="s2">"likes_received_count"</span> <span class="o">:</span> <span class="mi">27568</span><span class="p">,</span>
	<span class="s2">"projects_count"</span> <span class="o">:</span> <span class="mi">8</span><span class="p">,</span>
	<span class="s2">"rebounds_received_count"</span> <span class="o">:</span> <span class="mi">504</span><span class="p">,</span>
	<span class="s2">"shots_count"</span> <span class="o">:</span> <span class="mi">214</span><span class="p">,</span>
	<span class="s2">"teams_count"</span> <span class="o">:</span> <span class="mi">1</span><span class="p">,</span>
	<span class="s2">"can_upload_shot"</span> <span class="o">:</span> <span class="kc">true</span><span class="p">,</span>
	<span class="s2">"type"</span> <span class="o">:</span> <span class="s2">"Player"</span><span class="p">,</span>
	<span class="s2">"pro"</span> <span class="o">:</span> <span class="kc">true</span><span class="p">,</span>
	<span class="s2">"buckets_url"</span> <span class="o">:</span> <span class="s2">"https://dribbble.com/v1/users/1/buckets"</span><span class="p">,</span>
	<span class="s2">"followers_url"</span> <span class="o">:</span> <span class="s2">"https://dribbble.com/v1/users/1/followers"</span><span class="p">,</span>
	<span class="s2">"following_url"</span> <span class="o">:</span> <span class="s2">"https://dribbble.com/v1/users/1/following"</span><span class="p">,</span>
	<span class="s2">"likes_url"</span> <span class="o">:</span> <span class="s2">"https://dribbble.com/v1/users/1/likes"</span><span class="p">,</span>
	<span class="s2">"shots_url"</span> <span class="o">:</span> <span class="s2">"https://dribbble.com/v1/users/1/shots"</span><span class="p">,</span>
	<span class="s2">"teams_url"</span> <span class="o">:</span> <span class="s2">"https://dribbble.com/v1/users/1/teams"</span><span class="p">,</span>
	<span class="s2">"created_at"</span> <span class="o">:</span> <span class="s2">"2009-07-08T02:51:22Z"</span><span class="p">,</span>
	<span class="s2">"updated_at"</span> <span class="o">:</span> <span class="s2">"2014-02-22T17:10:33Z"</span>
<span class="p">}</span>
<span class="p">}</span></code></pre>

<h2 id="create-a-bucket">Benutzer registrieren</h2>

<pre><code>POST /user
</code></pre>

<p>Registriert einen neuen Benutzer für die Anwendung.</p>

<h3 id="parameters">Parameter</h3>

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Typ</th>
      <th>Beschreibung</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>name</code></td>
      <td><code>string</code></td>
      <td>
<strong>Required.</strong> The name of the bucket.</td>
    </tr>
    <tr>
      <td><code>description</code></td>
      <td><code>string</code></td>
      <td>A description of the bucket.</td>
    </tr>
  </tbody>
</table>

<h3 id="example">Example</h3>

<pre><code class="language-javascript"><span class="p">{</span>
  <span class="s2">"name"</span> <span class="o">:</span> <span class="s2">"Great Marks"</span><span class="p">,</span>
  <span class="s2">"description"</span> <span class="o">:</span> <span class="s2">"Collecting superb brand marks from the &lt;a href=\"https://dribbble.com\"&gt;Dribbbleverse&lt;/a&gt;."</span>
<span class="p">}</span></code></pre>

    </div> <!-- /container -->

	<?php

include('footer.php');

?>
