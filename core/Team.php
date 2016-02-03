<?php
	require_once('Player.php');

	Class Team
	{
		/**
		 * @access    public
		 * @since  	  0.1.0
		 * 
		 * @param     Object $skills Player skill sets
		 * 
		 * @return    void
		 */
		public function __construct($players=[])
		{
			$this->players = $players;
		}

		/**
		 * @access    public
		 * @since     0.1.0
		 * 
		 * @return    Player The player object
		 */
		public function getNames()
		{
			return array_map(function($player) {
				return $player->name;
			}, $this->players);
		}

		/**
		 * @access    public
		 * @since     0.1.0
		 * 
		 * @return    Player The player object
		 */
		public function add($player)
		{
			array_push($this->players, $player);

			return $player;
		}

		/**
		 * @access    public
		 * @since     0.1.0
		 * 
		 * @return    Array The sum of all the Player's skills
		 */
		public function level()
		{
			return [
				'attack' => $this->attack(),
				'defence' => $this->defence()
			];
		}

		/**
		 * @access public
		 * @since 0.1.0
		 * 
		 * @return Array The attack of all the players
		 */
		public function attack()
		{
			return array_reduce($this->playersAttack(), function($prevAttack, $currAttack) {
				return $prevAttack + $currAttack;
			});
		}

		/**
		 * @access public
		 * @since 0.1.0
		 * 
		 * @return Array The defence of all the players
		 */
		public function defence()
		{
			return array_reduce($this->playersDefence(), function($prevDefence, $currDefence) {
				return $prevDefence + $currDefence;
			});
		}

		/**
		 * @access private
		 * @since 0.1.0
		 * 
		 * @return Array The attack of all the players
		 */
		private function playersAttack()
		{
			return array_map(function($player) {
				return $player->skills['attack'];
			}, $this->players);
		}

		/**
		 * @access private
		 * @since 0.1.0
		 * 
		 * @return Array The defence of all the players
		 */
		private function playersDefence()
		{
			return array_map(function($player) {
				return $player->skills['defence'];
			}, $this->players);
		}
	}