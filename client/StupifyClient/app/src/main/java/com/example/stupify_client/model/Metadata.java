package com.example.stupify_client.model;

public class Metadata {
    private String serverIP;

    public Metadata() { }

    @Override
    public String toString() {
        return "Metadata{" +
                "serverIP='" + serverIP + '\'' +
                '}';
    }

    public String getServerIP() {
        return serverIP;
    }

    public void setServerIP(String serverIP) {
        this.serverIP = serverIP;
    }
}
