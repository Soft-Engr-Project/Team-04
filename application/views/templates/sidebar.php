	<div class="nav-item">
		<a class="navlink">
			<em class="fa fa-bars" onclick="collapseSidebar()"></em>
		</a>
	</div>
	<div class="sidebar">
		<ul class="sidebar-nav">
			<li class="sidebar-nav-item">
				<a href="#" class="sidebar-navlink">
					<div>
						<em class="fas fa-info-circle"></em>
					</div>
					<span>
						Personal Information
					</span>
				</a>
			</li>
			<li class="sidebar-nav-item">
				<a href="users_adminview.html" class="sidebar-navlink">
					<div>
						<em class="fas fa-caret-square-up"></em>
					</div>
					<span>Customization</span>
				</a>
			</li>
		</ul>
	</div>

<script>
const body = document.getElementsByTagName('body')[0]
function collapseSidebar() {
	body.classList.toggle('sidebar-expand')
}
</script>