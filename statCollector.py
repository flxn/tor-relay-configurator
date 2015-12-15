from stem.descriptor.remote import DescriptorDownloader
import os

downloader = DescriptorDownloader(
    use_mirrors = True,
    timeout = 10,
)

query = downloader.get_server_descriptors()

searchString = "[tor-relay.co]"
trcCount = 0
combinedUptime = 0
combinedBandwidth = 0

try:
    for desc in query.run():
        if searchString in str(desc.contact):
            trcCount += 1
            combinedUptime += desc.uptime
            combinedBandwidth += desc.observed_bandwidth

except Exception as exc:
    print exc

with open(os.path.join(os.path.dirname(__file__), 'misc/stats.txt'), 'w') as fh:
    fh.write(str(trcCount))
    fh.write("\n")
    fh.write(str(combinedUptime))
    fh.write("\n")
    fh.write(str(combinedBandwidth))

print trcCount
print combinedUptime
print combinedBandwidth
