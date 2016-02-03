<?php
	require_once('Team.php');

	Class TeamMaker
	{
		/**
		 * @access    public
		 * @since  	  0.1.0
		 * 
		 * @param     Object $skills Player skill sets
		 * 
		 * @return    void
		 */
		public function __construct($players)
		{
			$this->players = $players;
			$this->debt = 0;

			$this->pairPlayers();
		}

		/**
		 * @access    private
		 * @since     0.1.0
		 * 
		 * @return    Pair the number of players
		 */
		private function pairPlayers()
		{
			if(count($this->players) % 2 !== 0)
			{
				$emptyPlayer = new Player(
					'Empty',
					[
						'attack' => 0,
						'defence' => 0
					]
				);

				$this->players[] = $emptyPlayer;
			}
		}

		/**
		 * @access    public
		 * @since     0.1.0
		 * 
		 * @return    Array The sum of all the Player's skills
		 */
		public function makeTeams()
		{
			$team1 = new Team();
			$team2 = new Team();

			$playerLoop = $this->players;

			for($i=0;$i<count($this->players)/2;$i++) {
				$player = $playerLoop[0];
				$playerLoop = $this->filterPlayers($playerLoop, $team1, $player);

				$opponent = $this->closestTo($playerLoop, $player);
				
				$playerLoop = $this->filterPlayers($playerLoop, $team2, $opponent);

				sort($playerLoop); // Temp: need to find out how to take the first element of an unsorted array
			}

			return $this->compareTeams($team1, $team2) ? [$team1, $team2] : $this->makeTeams();
		}

		private function compareTeams($team1, $team2)
		{
			$t1strength = array_reduce($team1->level(), function($attack, $defence) {
				return $attack + $defence;
			});

			$t2strength = array_reduce($team2->level(), function($attack, $defence) {
				return $attack + $defence;
			});

			return $t1strength <= $t2strength + 6 && $t1strength >= $t2strength - 6;
		}

		/**
		 * @access    private
		 * @since     0.1.0
		 * 
		 * @param     Array $players The collection of all the players
		 * @param 	  Team The team wo add the player to
		 * @param 	  Player The player you want to add the to team
		 * @return    Array The collection of the players, without the given one
		 */
		private function filterPlayers($players, $team, $player)
		{
			$team->add($player);
			return $this->arrayRemoveObject($players, $player->name, 'name');
		}

		/**
		 * @access    private
		 * @since     0.1.0
		 * 
		 * @param     Player $player The player to find
		 * @return    Player The closest player to the given one
		 */
		private function closestTo($players, $player)
		{
			$playerLevel = $player->level() + $this->debt;
			$diff = 0;

			while (true) {
				foreach ($players as $opponent) {
					$opponentLevel = $opponent->level();

					if($playerLevel >= $opponentLevel - $diff && $playerLevel <= $opponentLevel + $diff) {
						$this->debt = $playerLevel - $opponentLevel;
						return $opponent;
					}
				}

				$diff++;
			}
		}

		/**
		 * @access    private
		 * @since     0.1.0
		 * 
		 * @param Array $array
		 * @param mixed $value
		 * @param string $prop
		 * 
		 * @return Array
		 */
		private function arrayRemoveObject(&$array, $value, $prop)
		{
		    return array_filter($array, function($a) use($value, $prop) {
		        return $a->$prop !== $value;
		    });
		}
	}