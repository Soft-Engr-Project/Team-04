	<div class="nav-item">
		<a class="navlink">
			<em class="fa fa-bars" onclick="collapseSidebar()"></em>
		</a>
	</div>
	<div class="sidebar">
		<ul class="sidebar-nav">
			<li class="sidebar-nav-item">
				<a href="<?php echo base_url();?>personalinfo/update" class="sidebar-navlink">
					<div>
						<em class="fas fa-info-circle"></em>
					</div>
					<span>
						Personal Information
					</span>
				</a>
			</li>
			<li class="sidebar-nav-item">
				<a href="<?php echo base_url();?>customization/view" class="sidebar-navlink">
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