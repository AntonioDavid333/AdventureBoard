<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faction;

class FactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faction::create([
            'name'=> 'The Ember Order',
            'description'=> 'The Ember Order is a militant religious faction devoted to the worship of the Flame, a divine force believed to bring both purification and destruction. Founded centuries ago after a cataclysmic fire swept through the eastern kingdoms, the Order sees fire as both a sacred tool and a test of faith. Members are known as Flamekeepers, zealots who wield fire magic and wear scorched armor as a symbol of their devotion. They believe that society must be cleansed of corruption, heresy, and darkness—sometimes literally by burning it down.
            The Order is feared and respected across the land. Though their actions can be extreme, they are often called upon to combat supernatural threats, especially undead and demons, which they view as affronts to the sacred Flame. Internally, the faction is governed by a strict hierarchy led by the Pyrewarden, who receives visions through ritual immolation. The Orders presence is strongest in the South, where they run grand cathedrals that double as training grounds for inquisitors. To outsiders, they are either saviors or fanatics. To themselves, they are the last hope in a world smoldering in moral decay.',
            'bonus_at' => 40,
            'bonus_def' => 10,
            'bonus_ki' => 50,
            'bonus_hp' => 30
        ]);

        Faction::create([
            'name'=> 'The Verdant Pact',
            'description'=> 'Deep within the ancient forests, the Verdant Pact thrives as a druidic alliance of elves, humans, and beastfolk who revere the balance of nature above all else. Formed in response to centuries of deforestation and exploitation, the Pact now defends the wilderness with unwavering resolve. Its members act as stewards, guardians, and sometimes avengers of the natural world, using primal magic and wild creatures to strike at those who threaten the land.
            They believe that civilization has grown too arrogant, severing its connection to the Earth. Their philosophy centers around symbiosis, restoration, and ancestral memory. The highest circle of leadership, known as the Groveheart Council, is made up of ancient druids and awakened treants who commune with the spirits of nature. The Pact is not inherently hostile to other factions, but they are known to sabotage mines, burn down lumber camps, and even unleash plagues against kingdoms that ignore their warnings.
            The Verdant Pact remains hidden to most, dwelling in living settlements grown from trees and moss. Their warriors—called Thornblades—fight with animal companions and enchanted nature-forged weapons. To cross the Pact is to risk invoking the wrath of the forest itself.',
            'bonus_at' => 20,
            'bonus_def' => 50,
            'bonus_ki' => 30,
            'bonus_hp' => 40
        ]);

        Faction::create([
            'name'=> 'The Obsidian Veil',
            'description'=> 'The Obsidian Veil is a clandestine network of spies, assassins, and arcane scholars who seek knowledge and power hidden in the shadows of history. They believe that true strength lies not in open war or loud proclamations, but in control of secrets, manipulation of fate, and silent dominion. The Veil has no known headquarters—only whispers, safehouses, and masked agents embedded in courts, guilds, and even enemy factions.
            Originally formed during an empire’s collapse, the Obsidian Veil vowed to never again let power be held by fools. They now act as unseen puppeteers, steering world events from behind closed doors. Their ranks include defected nobles, rogue mages, cursed bloodlines, and war orphans raised in secrecy. Their leadership, the Circle of Mirrors, is unknown even to most within the Veil.
            Magic within the Veil is forbidden unless shadow-bound—tied to illusions, memory tampering, or curses. They avoid open conflict but are capable of swift and merciless violence when required. While some view them as necessary evils protecting the world from chaos, others see them as a dangerous cabal hungry for dominion. Whatever the truth, the Obsidian Veil always knows more than they reveal—and they are never far away.',
            'bonus_at' => 30,
            'bonus_def' => 20,
            'bonus_ki' => 60,
            'bonus_hp' => 20
        ]);
    }
}
