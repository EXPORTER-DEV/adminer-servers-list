<?php
class ServersList {
	private $servers;

	private $drivers = [
		"server" => "MySQL",
		// "sqlite" => "SQLite 3",
		// "sqlite2" => "SQLite 2",
		"pgsql" => "PostgreSQL",
		"oracle" => "Oracle",
		"mssql" => "MS SQL",
		"firebird" => "Firebird",
		"simpledb" => "SimpleDB",
		"mongo" => "MongoDB",
		"elastic" => "Elasticsearch",
		"elastic7" => "Elasticsearch 7",
	];
	
	function __construct($servers){
		$this->servers = $this->formatServers($servers);
	}

	function formatServers($servers){
		return array_map(function($item){
			$item['driver'] = isset($item['driver']) ? $item['driver'] : 'server';
			return $item;
		}, $servers);
	}
	function formatDriver($driver){
        return isset($this->drivers[$driver]) ? $this->drivers[$driver] : $driver;
    }
	
	function loginForm(){ ?>
		</form>
		<table>
			<tr>
				<th>ID</th>
				<th><?php echo lang('System') ?></th>
				<th><?php echo lang('Server') ?></th>
				<th><?php echo lang('Username') ?></th>
				<th><?php echo lang('Database') ?></th>
				<th></th>
			</tr>
			<?php
			foreach($this->servers as $id => $server){
				$databases = isset($server['databases']) ? $server['databases'] : ["" => ""];
				foreach(array_keys($databases) as $i => $database){ ?>
					<tr>
						<?php if($i === 0){ ?>
							<td style="vertical-align:middle" rowspan="<?php echo count($databases) ?>">#<?php echo $id + 1; ?></td>
							<td style="vertical-align:middle" rowspan="<?php echo count($databases) ?>"><?php echo $this->formatDriver($server['driver']); ?></td>
							<td style="vertical-align:middle" rowspan="<?php echo count($databases) ?>"><?php echo isset($server['label']) ? "{$server['label']} ({$server['host']})" : $server['host']; ?></td>
							<td style="vertical-align:middle" rowspan="<?php echo count($databases) ?>"><?php echo $server['username'] ?></td>
						<?php } ?>
						<td style="vertical-align:middle"><?php echo $databases[$database] ?></td>	
						<td>
							<form action="" method="post">
								<input type="hidden" name="auth[driver]" value="<?php echo h($server['driver']); ?>">
								<input type="hidden" name="auth[server]" value="<?php echo h($server['host']); ?>">
								<input type="hidden" name="auth[username]" value="<?php echo h($server["username"]); ?>">
								<input type="hidden" name="auth[password]" value="<?php echo h($server["password"]); ?>">
								<input type='hidden' name="auth[db]" value="<?php echo h($database); ?>"/>
								<input type='hidden' name="auth[permanent]" value="1"/>
								<input type="submit" value="<?php echo lang('Login'); ?>">
							</form>
						</td>
					</tr>
				<?php }
			}	
			?>
		</table>
		<form action="" method="post">
			<table>
				<tr>
					<th><?php echo lang('System'); ?></th>
					<td><select name="auth[driver]">
						<?php 
							foreach($this->drivers as $driver => $name){
						?>
							<option value="<?php echo $driver ?>" <?php echo ($driver === DRIVER || (DRIVER === null && $driver === 'server')) ? 'selected="true"' : ''; ?>><?php echo $name; ?></option> 
						<?php
							}
						?>
					</select></td>
				</tr>
				<tr>
					<th><?php echo lang('Server'); ?></th>
					<td><input name="auth[server]" value="<?php echo SERVER !== null ? h(SERVER) : '127.0.0.1:3306'; ?>" placeholder="localhost" autocapitalize="off"></td>
				</tr>
				<tr>
					<th><?php echo lang('Username') ?></th>
					<td><input name="auth[username]" id="username" value="<?php echo isset($_GET['username']) ? h($_GET['username']) : "root"; ?>" autocomplete="username" autocapitalize="off"></td>
				</tr>
				<tr>
					<th><?php echo lang('Password') ?></th>
					<td><input type="password" name="auth[password]" autocomplete="current-password"></td>
				</tr>
				<tr>
					<th><?php echo lang('Database'); ?></th>
					<td><input name="auth[db]" value="<?php echo isset($_GET['db']) ? h($_GET['db']) : ""; ?>" autocapitalize="off"></td>
				</tr>
			</table>
			<p>
				<input type="submit" value="<?php echo lang('Login'); ?>" class="">
				<label><input type="checkbox" name="auth[permanent]" value="1" checked=""><?php echo lang('Permanent login'); ?></label>
			</p>
		</form>	
		<form action="" method="post">		
		<?php
		return true;
	}
}