#@story1394
#@voms
        Feature: Playlists Accept Multiple Overlays
        In order to have the ability for playlists to accept multiple overlays
        As a developer
        I want playlists to accept mutiple overlays
        
        @ignore
        Scenario: A playlist has multiple overlays
            Given that I am an IM
            When I implement multiple overlays for a piece of content
            Then I expect the playlist to understand and serve them in the player

        @service
        Scenario: Playlist with mutiple overlays
            Given 2 overlays have been associated with content item video version 1
            When video version 1 exists in the Static Playlist
            Then video version 1 will be served by the player
            And 2 overlays will be present in video version 1

        @service
        Scenario: Playlist with one overlay
            Given 1 overlay has been associated with content item video version 1
            When video version 1 exists in the Static Playlist
            Then video version 1 will be served by the player
            And 1 overlay will be present in video version 1

        @service
        Scenario: Playlist with no overays
            Given no overlays have been associated with content item video version 1
            When video version 1 exists in the Static Playlist
            Then video version 1 will be served by the player
            And no overlays will be present in video version 1
            