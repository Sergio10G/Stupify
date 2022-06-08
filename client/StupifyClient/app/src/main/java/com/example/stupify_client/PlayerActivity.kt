/*
 * Copyright (C) 2017 The Android Open Source Project
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
* limitations under the License.
 */
package com.example.stupify_client

import android.annotation.SuppressLint
import android.graphics.Bitmap
import android.graphics.drawable.BitmapDrawable
import android.net.Uri
import android.os.Bundle
import android.view.View
import androidx.appcompat.app.AppCompatActivity
import com.example.stupify_client.databinding.ActivityPlayerBinding
import com.example.stupify_client.model.FirebaseDAO
import com.example.stupify_client.model.Song
import com.google.android.exoplayer2.ExoPlayer
import com.google.android.exoplayer2.MediaItem
import com.google.android.exoplayer2.MediaMetadata
import com.google.android.exoplayer2.Player
import com.google.android.exoplayer2.ui.PlayerNotificationManager
import com.google.android.exoplayer2.ui.PlayerView
import com.google.android.exoplayer2.util.Util

/**
 * A fullscreen activity to play audio or video streams.
 */
class PlayerActivity : AppCompatActivity() {

    private lateinit var playerView: PlayerView
    private lateinit var playerNotifManager: PlayerNotificationManager

    private var playList = ArrayList<Song>()
    private var serverIP: String? = ""
    private var songId: Int? = -1
    private var catId: Int? = -1

    private var playWhenReady = true
    private var currentWindow = 0
    private var playbackPosition = 0L
    private var player: ExoPlayer? = null
    private var playerListener: Player.Listener = object: Player.Listener {

        override fun onMediaItemTransition(mediaItem: MediaItem?, reason: Int) {
            super.onMediaItemTransition(mediaItem, reason)
            if (bitmaps.size != 0) {
                val index = Integer.valueOf(player!!.currentMediaItem!!.mediaId)
                playerView.defaultArtwork = BitmapDrawable(resources, bitmaps[index])
            }
        }
    }

    private var bitmaps: HashMap<Int, Bitmap> = HashMap()

    private val viewBinding by lazy(LazyThreadSafetyMode.NONE) {
        ActivityPlayerBinding.inflate(layoutInflater)
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(viewBinding.root)

        playerView = findViewById(R.id.video_view)

        playerNotifManager = PlayerNotificationManager
                .Builder(this, 1234, "ChannelId")
                .build()

        val fbDAO = FirebaseDAO.getInstance()
        serverIP = intent.getStringExtra("serverIP")
        songId = intent.getIntExtra("songId", -1)
        catId = intent.getIntExtra("catId", -1)

        playList = fbDAO.getSongsByCategory(catId!!)
        val selectedSong = fbDAO.getSongById(songId!!)
        while (playList[0] != selectedSong) {
            val temp = playList[0]
            playList.removeAt(0)
            playList.add(temp)
        }

        bitmaps = fbDAO.songPhotos
    }

    override fun onStart() {
        super.onStart()
        if (player == null) {
            initializePlayer()
            val index = Integer.valueOf(player!!.currentMediaItem!!.mediaId)
            playerView.defaultArtwork = BitmapDrawable(resources, bitmaps[index])
        }
    }

    override fun onResume() {
        super.onResume()
        hideSystemUi()
        if (player == null) {
            initializePlayer()
        }
        playerNotifManager.setPlayer(player)
    }

    /*
    override fun onPause() {
        super.onPause()
        playerNotifManager.setPlayer(null)
        if (Util.SDK_INT < 24) {
            releasePlayer()
        }
    }

    override fun onStop() {
        super.onStop()
        playerNotifManager.setPlayer(null)
        if (Util.SDK_INT >= 24) {
            releasePlayer()
        }
    }
    */

    override fun onDestroy() {
        super.onDestroy()
        playerNotifManager.setPlayer(null)
        if (Util.SDK_INT >= 24) {
            releasePlayer()
        }
    }

    private fun initializePlayer() {
        player = ExoPlayer.Builder(this)
                .build()
                .also { exoPlayer ->
                    viewBinding.videoView.player = exoPlayer
                    for (song in playList) {
                        val mmdb =
                                MediaMetadata.Builder()
                                        .setTitle(song.title)
                                        .setArtist(song.author)
                                        .build();
                        val mediaItem =
                                MediaItem.Builder()
                                        .setMediaMetadata(mmdb)
                                        .setUri("http://" + serverIP + "/admin/songs/" + song.audiofile)
                                        .setMediaId("" + song.id)
                                        .build();
                        exoPlayer.addMediaItem(mediaItem)
                    }
                    exoPlayer.playWhenReady = playWhenReady
                    exoPlayer.seekTo(currentWindow, playbackPosition)
                    exoPlayer.prepare()
                }
        player!!.addListener(playerListener)
    }

    private fun releasePlayer() {
        player?.run {
            playbackPosition = this.currentPosition
            currentWindow = this.currentWindowIndex
            playWhenReady = this.playWhenReady
            release()
        }
        player = null
    }

    @SuppressLint("InlinedApi")
    private fun hideSystemUi() {
        viewBinding.videoView.systemUiVisibility = (View.SYSTEM_UI_FLAG_LOW_PROFILE
                or View.SYSTEM_UI_FLAG_FULLSCREEN
                or View.SYSTEM_UI_FLAG_LAYOUT_STABLE
                or View.SYSTEM_UI_FLAG_IMMERSIVE_STICKY
                or View.SYSTEM_UI_FLAG_LAYOUT_HIDE_NAVIGATION
                or View.SYSTEM_UI_FLAG_HIDE_NAVIGATION)
    }
}